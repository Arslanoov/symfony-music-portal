<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\ResetPassword\Request;

use Domain\Model\Flusher;
use Domain\Model\User\Email;
use Domain\Model\User\Exception\UserNotFound;
use Domain\Model\User\Login;
use Domain\Model\User\Service\Tokenizer;
use Domain\Model\User\UserRepository;
use Exception;

final class Handler
{
    private UserRepository $users;
    private Tokenizer $tokenizer;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param Tokenizer $tokenizer
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, Tokenizer $tokenizer, Flusher $flusher)
    {
        $this->users = $users;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $user = $this->users->getByLogin(new Login($command->login));
        if (!$user->getEmail()->isEqualTo(new Email($command->email))) {
            throw new UserNotFound();
        }

        $user->requestPasswordReset($this->tokenizer->generate());

        $this->flusher->flush();
    }
}
