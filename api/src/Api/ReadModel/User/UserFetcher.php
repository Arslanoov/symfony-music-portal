<?php

declare(strict_types=1);

namespace Api\ReadModel\User;

interface UserFetcher
{
    public function findForAuthByEmail(string $email): ?AuthView;

    public function findForAuthByLogin(string $login): ?AuthView;
}
