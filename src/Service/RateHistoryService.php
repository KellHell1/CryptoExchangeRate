<?php

namespace App\Service;

use App\Entity\CurrencyPair;
use App\Entity\RateHistory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RateHistoryService
{
    private $query;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private HttpClientInterface $client,
        private string $getRateUrl,
        private string $apiKey,
    ) {
        $this->getRateUrl = $_ENV['COIN_API_GET_RATE_URL'];
        $this->apiKey = $_ENV['COIN_API_KEY'];
        $this->query = ['query' => ['apikey' => $this->apiKey]];
    }


    private function sendRequest($url, $options, $method = 'GET')
    {
        try {
            $response = $this->client->request(
                $method,
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
        $this->entityManager->flush($rateHistory);

        return $rateHistory;
    }


    public function getRateHistoryByDates(int $currencyPairId, \DateTime $dateFrom, \DateTime $dateTo): array
    {
        $currencyPair = $this->entityManager->getRepository(CurrencyPair::class)->find($currencyPairId)
            ?? throw new NotFoundHttpException();

        return $this->entityManager->getRepository(RateHistory::class)->findBy(['currencyFrom' => $currencyPair->getCurrencyFrom(), 'currencyTo' => $currencyPair->getCurrencyTo()]);
    }
}