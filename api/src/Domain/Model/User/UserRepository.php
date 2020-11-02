<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Domain\Model\User\Exception\UserNotFound;

interface UserRepository
{
    public function findByLogin(Login $login): ?User;

    /**
     * @throws UserNotFound
     * @param Login $login
     * @return User
     */
    public function getByLogin(Login $login): User;

    public function findByEmail(Email $email): ?User;

    /**
     * @throws UserNotFound
     * @param Email $email
     * @return User
     */
    public function getByEmail(Email $email): User;

    public function findBySignUpConfirmToken(ConfirmToken $confirmToken): ?User;

    public function findByResetPasswordConfirmToken(ConfirmToken $confirmToken): ?User;

    public function add(User $user): void;
}
