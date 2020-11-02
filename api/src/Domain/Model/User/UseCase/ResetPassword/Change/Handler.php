<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\ResetPassword\Change;

use DateTimeImmutable;
use Domain\Model\Flusher;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Exception\IncorrectToken;
use Domain\Model\User\Exception\UserNotFound;
use Domain\Model\User\Login;
use Domain\Model\User\Password;
use Domain\Model\User\Service\PasswordHasher;
use Domain\Model\User\UserRepository;

final class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param PasswordHasher $hasher
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findByResetPasswordConfirmToken(
            new ConfirmToken($command->token, new DateTimeImmutable())
        )) {
            throw new IncorrectToken();
        }

        if (!$user->getLogin()->isEqualTo(new Login($command->login))) {
            throw new UserNotFound();
        }

        $user->confirmPasswordReset(
            new ConfirmToken($command->token, new DateTimeImmutable()),
            new Password($this->hasher->hash($command->newPassword))
        );

        $this->flusher->flush();
    }
}
