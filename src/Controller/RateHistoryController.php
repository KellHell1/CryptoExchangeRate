<?php

namespace App\Controller;

use App\Service\RateHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RateHistoryController extends AbstractController
{
    public function __construct(
        private RateHistoryService $rateHistoryService,
    )
    {
        // TODO: переделать через ДИ
        $this->rateHistoryService = new RateHistoryService();
    }

    #[Route('/rate/history', name: 'app_rate_history', methods: ['GET'])]
    public function getRateHistory(int $currencyPairId, \DateTime $dateFrom, \DateTime $dateTo): JsonResponse
    {
        $history = $this->rateHistoryService->getRateHistory($currencyPairId, $dateFrom, $dateTo);

        return new JsonResponse([
            $history
        ]);
    }
}
