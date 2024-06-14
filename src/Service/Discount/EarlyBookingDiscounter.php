<?php

namespace App\Service\Discount;

use App\Dto\CalculatorDto;
use App\Interface\DiscounterInterface;

class EarlyBookingDiscounter implements DiscounterInterface
{
    public function getDiscount(int $cost, CalculatorDto $dto): int
    {
        $tripDate = new \DateTime($dto->tripDate);
        $paymentDate = new \DateTime($dto->paymentDate);

        $discountPercentage = 0;

        if ($this->isSummerSeason($tripDate)) {
            $discountPercentage = $this->getSummerDiscount($paymentDate, $tripDate);
        } elseif ($this->isWinterSeason($tripDate)) {
            $discountPercentage = $this->getWinterDiscount($paymentDate, $tripDate);
        } elseif ($this->isOffSeason($tripDate)) {
            $discountPercentage = $this->getOffSeasonDiscount($paymentDate, $tripDate);
        }

        $discount = (int) ($cost * ($discountPercentage / 100));
        $discount = min($discount, 1500);

        return $cost - $discount;
    }

    /**
     * На путешествия с датой старта с 1 апреля по 30 сентября следующего года
     */
    private function isSummerSeason(\DateTime $tripDate): bool
    {
        $tripYear = (int) $tripDate->format('Y');
        return $tripDate >= new \DateTime("$tripYear-04-01") && $tripDate <= new \DateTime(($tripYear + 1) . "-09-30");
    }

    /**
     * при оплате весь ноябрь текущего и ранее скидка 7%;
     * весь декабрь текущего года - 5%;
     * весь январь следующего года - 3%.
     */
    private function getSummerDiscount(\DateTime $paymentDate, \DateTime $tripDate): int
    {
        $tripYear = (int) $tripDate->format('Y');
        $currentYear = $tripYear - 1;

        if ($paymentDate < new \DateTime("$currentYear-12-01")) {
            return 7;
        }

        if ($paymentDate < new \DateTime("$currentYear-12-31")) {
            return 5;
        }

        return 3;
    }

    /**
     * На путешествия с датой старта с 1 октября текущего года по 14 января следующего года
     */
    private function isWinterSeason(\DateTime $tripDate): bool
    {
        $tripYear = (int) $tripDate->format('Y');
        return $tripDate >= new \DateTime(($tripYear - 1) . "-10-01") && $tripDate <= new \DateTime("$tripYear-01-14");
    }

    /**
     * при оплате весь март текущего года и ранее скидка 7%;
     * весь апрель текущего года - 5%;
     * весь май текущего года - 3%.
     */
    private function getWinterDiscount(\DateTime $paymentDate, \DateTime $tripDate): int
    {
        $tripYear = (int) $tripDate->format('Y');
        $currentYear = $tripYear - 1;

        if ($paymentDate < new \DateTime("$currentYear-04-01")) {
            return 7;
        }

        if ($paymentDate < new \DateTime("$currentYear-05-01")) {
            return 5;
        }

        return 3;
    }

    /**
     * На путешествия с датой старта с 15 января следующего года и далее
     */
    private function isOffSeason(\DateTime $tripDate): bool
    {
        $tripYear = (int) $tripDate->format('Y');
        return $tripDate >= new \DateTime("$tripYear-01-15");
    }

    /**
     * при оплате весь август текущего года и ранее скидка 7%;
     * весь сентябрь текущего года - 5%;
     * весь октябрь текущего года - 3%.
     */
    private function getOffSeasonDiscount(\DateTime $paymentDate, \DateTime $tripDate): int
    {
        $tripYear = (int) $tripDate->format('Y');
        $currentYear = $tripYear - 1;

        if ($paymentDate < new \DateTime("$currentYear-09-01")) {
            return 7;
        }

        if ($paymentDate < new \DateTime("$currentYear-10-01")) {
            return 5;
        }

        return 3;
    }
}