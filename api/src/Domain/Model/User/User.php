<?php

declare(strict_types=1);

namespace Domain\Model\User;

final class User
{
    private Id $id;
    private Name $name;
    private Email $email;

    /**
     * User constructor.
     * @param Id $id
     * @param Name $name
     * @param Email $email
     */
    public function __construct(Id $id, Name $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function signUpByEmail(Id $id, Name $name, Email $email): self
    {
        return new self(
            $id, $name, $email
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
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
}