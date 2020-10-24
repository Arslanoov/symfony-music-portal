<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

final class User
{
    private Id $id;
    private Email $email;

    /**
     * User constructor.
     * @param Id $id
     * @param Email $email
     */
    private function __construct(Id $id, Email $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public static function signUpByEmail(Id $id, Email $email): self
    {
        return new self(
            $id, $email
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
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
}