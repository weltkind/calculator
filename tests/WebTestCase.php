<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebCase;

class WebTestCase extends BaseWebCase
{

    protected static function createClient(array $options = [], array $server = []): KernelBrowser
    {
        $client = parent::createClient([], ['HTTP_HOST' => $_SERVER['HTTP_HOST']]);
        $client->catchExceptions(false);

        return $client;
    }

    protected function tearDown(): void
    {
        restore_exception_handler();
        parent::tearDown();
    }
}
