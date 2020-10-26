<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\SignUp\Request;

use Domain\Model\Flusher;
use Domain\Model\User\Age;
use Domain\Model\User\Email;
use Domain\Model\User\Exception\UserWithCurrentEmailAlreadyExists;
use Domain\Model\User\Exception\UserWithCurrentLoginAlreadyExists;
use Domain\Model\User\Id;
use Domain\Model\User\Login;
use Domain\Model\User\Name;
use Domain\Model\User\Password;
use Domain\Model\User\Service\PasswordHasher;
use Domain\Model\User\Service\Tokenizer;
use Domain\Model\User\User;
use Domain\Model\User\UserRepository;

final class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Tokenizer $tokenizer;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param PasswordHasher $hasher
     * @param Tokenizer $tokenizer
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, PasswordHasher $hasher, Tokenizer $tokenizer, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->users->findByLogin($login = new Login($command->login))) {
            throw new UserWithCurrentLoginAlreadyExists('User with this login already exists.');
        }
        if ($this->users->findByEmail($email = new Email($command->email))) {
            throw new UserWithCurrentEmailAlreadyExists('User with this email already exists.');
        }

        $user = User::signUpByEmail(
            new Id($command->id),
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Login($command->login),
            $email,
            new Age($command->age),
            new Password(
                $this->hasher->hash($command->password)
            ),
            $this->tokenizer->generate()
        );

        $this->users->add($user);

        $this->flusher->flush();
    }
}
