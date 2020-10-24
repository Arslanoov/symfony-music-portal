<?php

declare(strict_types=1);

namespace Domain\Model\User;

final class User
{
    private Id $id;
    private Name $name;
    private Login $login;
    private Email $email;
    private Age $age;

    /**
     * User constructor.
     * @param Id $id
     * @param Name $name
     * @param Login $login
     * @param Email $email
     * @param Age $age
     */
    public function __construct(Id $id, Name $name, Login $login, Email $email, Age $age)
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->age = $age;
    }

    public static function signUpByEmail(Id $id, Name $name, Login $login, Email $email, Age $age): self
    {
        return new self(
            $id, $name, $login, $email, $age
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
}