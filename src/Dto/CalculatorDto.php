<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CalculatorDto
{
    /**
     * @Assert\NotBlank(message="Стоимость не должна быть пустой.")
     * @Assert\Type(type="numeric", message="Стоимость должна быть числом.")
     */
    public $cost;

    /**
     * @Assert\NotBlank(message="Дата рождения не должна быть пустой.")
     * @Assert\Date(message="Дата рождения должна быть допустимой датой.")
     */
    public $birthDate;

    /**
     * @Assert\NotBlank(message="Дата поездки не должна быть пустой.")
     * @Assert\Date(message="Дата поездки должна быть допустимой датой.")
     */
    public $tripDate;

    /**
     * @Assert\NotBlank(message="Дата оплаты не должна быть пустой.")
     * @Assert\Date(message="Дата оплаты должна быть допустимой датой.")
     */
    public $paymentDate;
}