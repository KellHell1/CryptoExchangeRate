<?php

namespace App\Controller;

use App\Service\RateHistoryService;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RateHistoryController extends AbstractController
{
    public function __construct(
        private RateHistoryService $rateHistoryService,
    ) {

    }

    #[Route('/rate/history/{currencyPairId}', name: 'app_rate_history', methods: ['GET'])]
    public function getRateHistory(int $currencyPairId, Request $request): JsonResponse
    {
        $dateFrom =  new DateTime($request->get('dateFrom'));
        $dateTo = new DateTime($request->get('dateTo'));

        // если предполагается что история не будет отображаться вся сразу в определенных кейсах, то еще делаем пагинацию
        $history = $this->rateHistoryService->getRateHistoryByDates($currencyPairId, $dateFrom, $dateTo);

        return new JsonResponse(
            [
                'currencyPairId' => $currencyPairId,
                'history' => $history,
                'items' => count($history),
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ]
        );
    }
}
