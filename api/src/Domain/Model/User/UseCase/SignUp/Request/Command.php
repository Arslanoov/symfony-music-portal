<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\SignUp\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="32")
     */
    public string $firstName;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="32")
     */
    public string $lastName;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="16")
     */
    public string $login;
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\GreaterThan(11)
     * @Assert\LessThan(100)
     */
    public int $age;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="6")
     */
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