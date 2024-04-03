<?php

namespace App\Service;

use App\Entity\CurrencyPair;
use App\Entity\RateHistory;
use App\Repository\RateHistoryRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RateHistoryService
{
    private array $query;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private RateHistoryRepository $rateHistoryRepository,
        private HttpClientInterface $client,
        private string $getRateUrl,
        private string $apiKey,
    ) {
        $this->query = ['query' => ['apikey' => $this->apiKey]];
    }


    private function sendRequest(string $url, array $options): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $url,
                $options
            );
        } catch (TransportExceptionInterface $e) {
            // пишем в логи о ошибке
        }

        return isset($response) ? $response->toArray() : [];
    }

    public function getRateByApi(CurrencyPair $currencyPair): array
    {
        $currencyFrom = $currencyPair->getCurrencyFrom()->getCode();
        $currencyTo = $currencyPair->getCurrencyTo()->getCode();

        return $this->sendRequest($this->getRateUrl . "/$currencyFrom" . "/$currencyTo", $this->query);
    }


    public function saveRateHistory(CurrencyPair $currencyPair, array $response): RateHistory
    {
        $rateHistory = new RateHistory();

        $rateHistory->setRate($response['rate']);
        $rateHistory->setCurrencyPair($currencyPair);

        $dateTime = new DateTime($response['time']);
        $rateHistory->setDatetime($dateTime);

        $this->entityManager->persist($rateHistory);
        $this->entityManager->flush();

        return $rateHistory;
    }


    public function getRateHistoryByDates(int $currencyPairId, DateTime $dateFrom, DateTime $dateTo): array
    {
        // тут с фронтом надо согласовать как выкидывать лучше в случае NotFound
        $currencyPair = $this->entityManager->getRepository(CurrencyPair::class)->find($currencyPairId)
            ?? throw new NotFoundHttpException();

        $history = [];
        $rateHistory = $this->rateHistoryRepository->findByDateTimeRangeAndPair($currencyPair, $dateFrom, $dateTo);

        foreach ($rateHistory as $item) {
            // для графика важно день+час, убрал минуты с секундами
            // так же можно было б добавить к каждому шагу, процентное соотношение повышения или понижения цены от предыдущей, если фронт не будет это делать сам
            $history[] = [$item->getDatetime()->format('Y-m-d H') => $item->getRate()];
        }

        return $history;
    }
}