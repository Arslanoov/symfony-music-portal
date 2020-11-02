<?php

declare(strict_types=1);

namespace Test\Functional\Api\ResetPassword;

use Test\Functional\FunctionalTestCase;

class ConfirmTest extends FunctionalTestCase
{
    private const URI = '/api/reset-password/change';

    public function testSuccess(): void
    {
        $successLogin = 'requestedLogin';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $successLogin,
                'token' => 'requested',
                'new_password' => 'secret'
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(204, $response->getStatusCode());
    }

    public function testNotFoundLogin(): void
    {
        $notFoundLogin = 'notFound';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $notFoundLogin,
                'token' => 'requested',
                'new_password' => 'secret'
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame([
            'message' => 'User not found.'
        ], json_decode($response->getContent(), true));
    }

    public function testIncorrectToken(): void
    {
        $successLogin = 'requestedLogin';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $successLogin,
                'token' => 'incorrect',
                'new_password' => 'secret'
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(419, $response->getStatusCode());
        $this->assertSame([
            'message' => 'Incorrect token.'
        ], json_decode($response->getContent(), true));
    }

    public function testExpiredToken(): void
    {
        $expiredLogin = 'expiredPLogin';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $expiredLogin,
                'token' => 'expired',
                'new_password' => 'secret'
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(419, $response->getStatusCode());
        $this->assertSame([
            'message' => 'Token is expired.'
        ], json_decode($response->getContent(), true));
    }
}