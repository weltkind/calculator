<?php

namespace App\Controller;

use App\Dto\CalculatorDto;
use App\Handler\RequestHandler;
use App\Service\CalculatorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class CalculatorController extends AbstractController
{
    public function __construct(
        private readonly RequestHandler $requestHandler,
        private readonly CalculatorService $calculatorService
    ) {
    }

    #[Route('/calculate', name: 'calculate', methods: ["POST"])]
    public function calculate(
        Request $request,
    ): Response {
        $calculatorDto = $this->requestHandler->handleRequest($request, CalculatorDto::class);

        return $this->json([
            'result' => $this->calculatorService->calculate($calculatorDto)
        ]);
    }
}