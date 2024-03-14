<?php

namespace App\Service;

use App\Entity\CurrencyPair;

class RateHistoryService
{
    public function getRateByApi(CurrencyPair $currencyPair): array
    {
        return [];
    }


    public function saveRate(CurrencyPair $currencyPair): array
    {
        return [];
    }


    public function getRateHistory(CurrencyPair $currencyPair, \DateTime $dateFrom, \DateTime $dateTo): array
    {
        return [];
    }
}