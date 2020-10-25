<?php

declare(strict_types=1);

namespace Test\Functional\Api;

use Test\Functional\FunctionalTestCase;

class HomeTest extends FunctionalTestCase
{
    public function testSuccess(): void
    {
        $this->client->request('GET', '/api');

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'version' => '1.0'
        ], json_decode($response->getContent(), true));
    }
}