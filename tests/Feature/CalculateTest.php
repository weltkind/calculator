<?php

namespace App\Tests\Feature;

use App\Tests\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use PHPUnit\Framework\Attributes\DataProvider;

class CalculateTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    #[DataProvider('provideCalculateData')]
    public function testCalculate(
        int $cost,
        string $birthDate,
        string $tripDate,
        string $paymentDate,
        int $expectedDiscount
    ): void {
        $data = [
            "cost" => $cost,
            "birthDate" => $birthDate,
            "tripDate" => $tripDate,
            "paymentDate" => $paymentDate
        ];

        $this->client->request(
            'POST',
            '/calculate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('result', $response);

        $expectedResult = $cost - $expectedDiscount;
        $this->assertEquals($expectedResult, $response['result']);
    }


    public static function provideCalculateData(): array
    {
        return [
            'discount 7%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '01.07.2024',
                'paymentDate' => '01.11.2023',
                'expectedDiscount' => (int) (10000 * 0.07)
            ],

            'discount 3%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '01.07.2024',
                'paymentDate' => '15.01.2024',
                'expectedDiscount' => (int) (10000 * 0.03)
            ],
            'march discount 7%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '01.11.2025',
                'paymentDate' => '15.05.2024',
                'expectedDiscount' => (int) (10000 * 0.07)
            ],
            'april discount 7%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '01.11.2025',
                'paymentDate' => '15.05.2024',
                'expectedDiscount' => (int) (10000 * 0.07)
            ],

            'may discount 3%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '01.11.2024',
                'paymentDate' => '15.05.2024',
                'expectedDiscount' => (int) (10000 * 0.03)
            ],
            'august discount 7%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '15.01.2025',
                'paymentDate' => '01.08.2024',
                'expectedDiscount' => (int) (10000 * 0.07)
            ],
            'september discount 5%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '15.01.2025',
                'paymentDate' => '15.09.2024',
                'expectedDiscount' => (int) (10000 * 0.05)
            ],
            'october discount 3%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2000',
                'tripDate' => '15.01.2025',
                'paymentDate' => '15.10.2024',
                'expectedDiscount' => (int) (10000 * 0.03)
            ],
            'kids discount 7%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2022',
                'tripDate' => '15.01.2025',
                'paymentDate' => '01.08.2024',
                'expectedDiscount' => 2560
            ],
            'kids discount 5%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2018',
                'tripDate' => '15.01.2025',
                'paymentDate' => '15.09.2024',
                'expectedDiscount' => 7150
            ],
            'kids discount 3%' => [
                'cost' => 10000,
                'birthDate' => '01.02.2016',
                'tripDate' => '15.01.2025',
                'paymentDate' => '15.10.2024',
                'expectedDiscount' => 7090
            ],
        ];
    }
}