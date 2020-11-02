<?php

declare(strict_types=1);

namespace Domain\Model\User\Event;

class UserPasswordChanged
{
    public string $id;
    public string $login;
    public string $email;

    /**
     * UserPasswordChanged constructor.
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
