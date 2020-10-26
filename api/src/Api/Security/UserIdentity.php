<?php

declare(strict_types=1);

namespace Api\Security;

use Domain\Model\User\Status;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface, EquatableInterface
{
    private string $id;
    private string $login;
    private string $email;
    private string $password;
    private string $status;

    public function __construct(
        string $id,
        string $login,
        string $email,
        string $password,
        string $status
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isDraft(): bool
    {
        return $this->status === Status::STATUS_DRAFT;
    }

    public function getRoles(): array
    {
        // TODO: add user role
        return ['ROLE_USER'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        return
            $this->id === $user->id and
            $this->login === $user->login and
            $this->email === $user->email and
            $this->password === $user->password and
            $this->status === $user->status
        ;
    }
}
