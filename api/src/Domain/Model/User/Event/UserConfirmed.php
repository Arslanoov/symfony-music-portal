<?php

declare(strict_types=1);

namespace Domain\Model\User\Event;

final class UserConfirmed
{
    public string $login;
    public string $email;

    /**
     * UserConfirmed constructor.
     * @param string $login
     * @param string $email
     */
    public function __construct(string $login, string $email)
    {
        // TODO: add email

        $this->login = $login;
        $this->email = $email;
    }
}