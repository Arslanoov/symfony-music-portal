<?php

declare(strict_types=1);

namespace Test\Functional\Api\ResetPassword;

use Test\Functional\FunctionalTestCase;

class RequestTest extends FunctionalTestCase
{
    private const URI = '/api/reset-password';

    public function testSuccess(): void
    {
        $successLogin = 'successLogin';
        $successEmail = 'success@user.com';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $successLogin,
                'email' => $successEmail
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([
            'email' => $successEmail
        ], json_decode($response->getContent(), true));
    }

    public function testNotFoundLogin(): void
    {
        $successLogin = 'notFound';
        $successEmail = 'success@user.com';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $successLogin,
                'email' => $successEmail
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame([
            'message' => 'User not found.'
        ], json_decode($response->getContent(), true));
    }

    public function testNotFoundEmail(): void
    {
        $successLogin = 'successLogin';
        $successEmail = 'notfound@user.com';

        $this->client->request(
            'POST',
            self::URI,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'login' => $successLogin,
                'email' => $successEmail
            ])
        );

        $response = $this->client->getResponse();

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame([
            'message' => 'User not found.'
        ], json_decode($response->getContent(), true));
    }
}