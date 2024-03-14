<?php

namespace App\Service;

use App\Entity\CurrencyPair;
use App\Entity\RateHistory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RateHistoryService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private HttpClientInterface $client,
        private string $getRateUrl,
        private string $apiKey,
        private array $query,
    ) {
        $this->getRateUrl = $_ENV['COIN_API_GET_RATE_URL'];
        $this->apiKey = $_ENV['COIN_API_KEY'];
        $this->query = [
            'apikey' => $this->apiKey
        ];
    }


    private function sendRequest($url, $options = ['query' => $this->query], $method = 'GET')
    {
        try {
            $response = $this->client->request(
                $method,
                $url . $this->apiKey,
                $options
            );
        } catch (TransportExceptionInterface $e) {
            // пишем в логи о ошибке
        }

        return isset($response) ? $response->toArray() : [];
    }

    private function getRateByApi(CurrencyPair $currencyPair): array
    {
        $currencyFrom = $currencyPair->getCurrencyFrom()->getCode();
        $currencyTo = $currencyPair->getCurrencyTo()->getCode();

        return $this->sendRequest($this->getRateUrl . "/$currencyFrom" . "/$currencyTo");
    }


    private function saveRateHistory(CurrencyPair $currencyPair, array $response): array
    {
        $rateHistory = new RateHistory();

        $rateHistory->setRate($response['rate']);
        $rateHistory->setCurrencyPair($currencyPair);
        $rateHistory->setDatetime($response['time']);

        $this->entityManager->persist($rateHistory);
        $this->entityManager->flush($rateHistory);

        return ['status' => 'ok'];
    }


    public function getRateHistory(int $currencyPairId, \DateTime $dateFrom, \DateTime $dateTo): array
    {
        $currencyPair = $this->entityManager->getRepository(CurrencyPair::class)->find($currencyPairId)
            ?? throw new NotFoundHttpException();

        return $this->entityManager->getRepository(RateHistory::class)->findBy(['currencyFrom' => $currencyPair->getCurrencyFrom(), 'currencyTo' => $currencyPair->getCurrencyTo()]);
    }
}