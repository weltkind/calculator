<?php

namespace App\Interface;

use App\Dto\CalculatorDto;

interface DiscounterInterface
{
    public function getDiscount(int $cost, CalculatorDto $dto): int;
}