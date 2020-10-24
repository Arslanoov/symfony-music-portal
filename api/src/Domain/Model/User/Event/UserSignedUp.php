<?php

declare(strict_types=1);

namespace Domain\Model\User\Event;

final class UserSignedUp
{
    public string $id;
    public string $login;
    public string $email;

    /**
     * UserSignedUp constructor.
     * @param string $id
     * @param string $login
     * @param string $email
     */
    public function __construct(string $id, string $login, string $email)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
    }
}