<?php

namespace App\Service\Discount;

use App\Dto\CalculatorDto;
use App\Interface\DiscounterInterface;

class KidDiscounter implements DiscounterInterface
{
    public function getDiscount(int $cost, CalculatorDto $dto): int
    {
        $birthDate = new \DateTime($dto->birthDate);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;

        if ($age < 6) {
            return (int) ($cost * 0.80);
        }

        if ($age >= 6 && $age < 12) {
            $discount = $cost * 0.30;
            return $discount > 4500 ? 4500 : (int) $discount;
        }

        if ($age >= 12 && $age < 18) {
            return (int) ($cost * 0.10);
        }

        return $cost;
    }
}