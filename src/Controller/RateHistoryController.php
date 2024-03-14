<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RateHistoryController extends AbstractController
{
    #[Route('/rate/history', name: 'app_rate_history', methods: ['GET'])]
    public function getRateHistory(): JsonResponse
    {
        return $this->json([
            'message' => 'Rate History',
            'path' => 'src/Controller/RateHistoryController.php',
        ]);
    }
}
