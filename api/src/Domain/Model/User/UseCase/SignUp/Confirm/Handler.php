<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\SignUp\Confirm;

use DateTimeImmutable;
use Domain\Model\Flusher;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Exception\IncorrectToken;
use Domain\Model\User\UserRepository;

final class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findBySignUpConfirmToken(
            new ConfirmToken($command->token, new DateTimeImmutable())
        )) {
            throw new IncorrectToken();
        }

        $user->confirmSignUp();

        $this->flusher->flush();
    }
}
