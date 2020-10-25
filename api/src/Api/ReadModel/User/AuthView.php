<?php

declare(strict_types=1);

namespace Api\ReadModel\User;

final class AuthView
{
    public string $id;
    public string $login;
    public string $email;
    public string $password;
    public string $status;
}