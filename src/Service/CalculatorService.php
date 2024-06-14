<?php

namespace App\Service;

use App\Dto\CalculatorDto;

class CalculatorService
{
    public function __construct(private readonly array $discounters)
    {
    }

    public function calculate(CalculatorDto $dto): float
    {
        $cost = $dto->cost;
        foreach ($this->discounters as $discounter) {
            $cost = $discounter->getDiscount($cost, $dto);
        }

        return $cost;
    }
}