<?php

declare(strict_types=1);

namespace Domain\Model\User;

use DateTimeImmutable;
use Domain\Model\AggregateRoot;
use Domain\Model\EventsTrait;
use Domain\Model\User\Event\UserSignedUp;

final class User implements AggregateRoot
{
    use EventsTrait;

    private Id $id;
    private DateTimeImmutable $createdAt;
    private Name $name;
    private Login $login;
    private Email $email;
    private Age $age;
    private Password $password;

    /**
     * User constructor.
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param Name $name
     * @param Login $login
     * @param Email $email
     * @param Age $age
     * @param Password $password
     */
    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        Name $name,
        Login $login,
        Email $email,
        Age $age,
        Password $password
    ) {
        $this->id = $id;
        $this->createdAt = $date;
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->age = $age;
        $this->password = $password;

        $this->recordEvent(new UserSignedUp(
            $id->getValue(),
            $login->getValue(),
            $email->getValue()
        ));
    }

    public static function signUpByEmail(
        Id $id,
        Name $name,
        Login $login,
        Email $email,
        Age $age,
        Password $password
    ): self {
        return new self(
            $id,
            new DateTimeImmutable(),
            $name,
            $login,
            $email,
            $age,
            $password
        );
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Login
     */
    public function getLogin(): Login
    {
        return $this->login;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Age
     */
    public function getAge(): Age
    {
        return $this->age;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }
}