<?php

declare(strict_types=1);

namespace Test\Functional\Api\SignUp;

use Test\Functional\FunctionalTestCase;

class RequestTest extends FunctionalTestCase
{
    private const URI = '/api/sign-up';

    public function testSuccess(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => 'Vasya',
            'last_name' => 'Pupkin',
            'login' => 'userLogin',
            'age' => 25,
            'email' => $email = 'user@app.test',
            'password' => 'secret'
        ]));

        $response = $this->client->getResponse();

        $this->assertSame(201, $response->getStatusCode());
        $this->assertEquals([
            'email' => $email
        ], json_decode($response->getContent(), true));
    }

    public function testValidationErrors(): void
    {
        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => '',
            'last_name' => '',
            'login' => '',
            'age' => 2,
            'email' => 'not an email',
            'password' => ''
        ]));

        $response = $this->client->getResponse();

        $this->assertSame(422, $response->getStatusCode());
        $this->assertArraySubset([
            'violations' => [
                ['propertyPath' => 'firstName', 'title' => 'This value should not be blank.'],
                ['propertyPath' => 'firstName', 'title' => 'This value is too short. It should have 2 characters or more.'],
                ['propertyPath' => 'lastName', 'title' => 'This value should not be blank.'],
                ['propertyPath' => 'lastName', 'title' => 'This value is too short. It should have 2 characters or more.'],
                ['propertyPath' => 'login', 'title' => 'This value should not be blank.'],
                ['propertyPath' => 'login', 'title' => 'This value is too short. It should have 4 characters or more.'],
                ['propertyPath' => 'age', 'title' => 'This value should be greater than 11.'],
                ['propertyPath' => 'email', 'title' => 'This value is not a valid email address.'],
                ['propertyPath' => 'password', 'title' => 'This value should not be blank.'],
                ['propertyPath' => 'password', 'title' => 'This value is too short. It should have 6 characters or more.']
            ],
        ], json_decode($response->getContent(), true));
    }

    public function testLoginAlreadyExists(): void
    {
        $this->testSuccess();

        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => 'Vasya',
            'last_name' => 'Pupkin',
            'login' => 'userLogin',
            'age' => 25,
            'email' => 'some@app.test',
            'password' => 'secret'
        ]));

        $response = $this->client->getResponse();

        $this->assertEquals([
            'message' => 'User with this login already exists.',
        ], json_decode($response->getContent(), true));
    }

    public function testEmailAlreadyExists(): void
    {
        $this->testSuccess();

        $this->client->request('POST', self::URI, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'first_name' => 'Vasya',
            'last_name' => 'Pupkin',
            'login' => 'someAnotherLogin',
            'age' => 25,
            'email' => 'user@app.test',
            'password' => 'secret'
        ]));

        $response = $this->client->getResponse();

        $this->assertEquals([
            'message' => 'User with this email already exists.',
        ], json_decode($response->getContent(), true));
    }
}