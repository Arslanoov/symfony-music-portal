<?php

declare(strict_types=1);

namespace Test\Functional\Api\SignUp;

use Test\Functional\FunctionalTestCase;

class ConfirmTest extends FunctionalTestCase
{
    private const URI = '/api/sign-up/confirm';

    public function testSuccess(): void
    {
        $this->client->request('POST', self::URI . '/success_token', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(204, $response->getStatusCode());
    }

    public function testNotValid(): void
    {
        $this->client->request('POST', self::URI . '/not_valid_token', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(419, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Incorrect token.'
        ], json_decode($response->getContent(), true));
    }

    public function testExpired(): void
    {
        $this->client->request('POST', self::URI . '/expired_token', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(419, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Token is expired.'
        ], json_decode($response->getContent(), true));
    }
}