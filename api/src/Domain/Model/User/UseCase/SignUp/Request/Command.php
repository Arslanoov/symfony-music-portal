<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\SignUp\Request;

final class Command
{
    public string $id;
    public string $firstName;
    public string $lastName;
    public string $login;
    public int $age;
    public string $email;
    public string $password;

    /**
     * Command constructor.
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $login
     * @param int $age
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $login,
        int $age,
        string $email,
        string $password
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->login = $login;
        $this->age = $age;
        $this->email = $email;
        $this->password = $password;
    }
}