<?php

declare(strict_types=1);

namespace Domain\Model\User;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Domain\Model\AggregateRoot;
use Domain\Model\EventsTrait;
use Domain\Model\User\Event\UserConfirmed;
use Domain\Model\User\Event\UserSignedUp;
use Domain\Model\User\Exception\TokenExpired;
use Domain\Model\User\Exception\UserAlreadyActivated;

/**
 * Class User
 * @package Domain\Model\User
 * @ORM\Entity()
 * @ORM\Table(name="user_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"login"}),
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User implements AggregateRoot
{
    use EventsTrait;

    /**
     * @var Id
     * @ORM\Id()
     * @ORM\Column(type="user_user_id", name="id")
     */
    private Id $id;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="created_at")
     */
    private DateTimeImmutable $createdAt;
    /**
     * @var Name
     * @ORM\Embedded(columnPrefix="name_", class="Domain\Model\User\Name")
     */
    private Name $name;
    /**
     * @var Login
     * @ORM\Column(type="user_user_login", length=16)
     */
    private Login $login;
    /**
     * @var Email
     * @ORM\Column(type="user_user_email", length=32)
     */
    private Email $email;
    /**
     * @var Age
     * @ORM\Column(type="user_user_age")
     */
    private Age $age;
    /**
     * @var Password
     * @ORM\Column(type="user_user_password", length=128)
     */
    private Password $password;
    /**
     * @var Status
     * @ORM\Column(type="user_user_status", length=8)
     */
    private Status $status;
    /**
     * @var ConfirmToken|null
     * @ORM\Embedded(columnPrefix="sign_up_confirm_token_", class="Domain\Model\User\ConfirmToken")
     */
    private ?ConfirmToken $signUpConfirmToken;

    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        Name $name,
        Login $login,
        Email $email,
        Age $age,
        Password $password,
        Status $status,
        ?ConfirmToken $signUpConfirmToken = null
    ) {
        $this->id = $id;
        $this->createdAt = $date;
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->age = $age;
        $this->password = $password;
        $this->status = $status;
        $this->signUpConfirmToken = $signUpConfirmToken;
    }

    public static function signUpByEmail(
        Id $id,
        Name $name,
        Login $login,
        Email $email,
        Age $age,
        Password $password,
        ConfirmToken $signUpConfirmToken
    ): self {
        $user = new self(
            $id,
            new DateTimeImmutable(),
            $name,
            $login,
            $email,
            $age,
            $password,
            Status::draft(),
            $signUpConfirmToken
        );

        $user->recordEvent(new UserSignedUp(
            $id->getValue(),
            $login->getValue(),
            $email->getValue(),
            $signUpConfirmToken->getToken()
        ));

        return $user;
    }

    public function confirmSignUp(): void
    {
        if ($this->isActive()) {
            throw new UserAlreadyActivated();
        }

        if ($this->signUpConfirmToken->isExpiredTo(new DateTimeImmutable())) {
            throw new TokenExpired();
        }

        $this->activate();
        $this->signUpConfirmToken = null;

        $this->recordEvent(new UserConfirmed(
            $this->getLogin()->getValue(),
            $this->getEmail()->getValue()
        ));
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isDraft(): bool
    {
        return $this->status->isDraft();
    }

    private function activate(): void
    {
        $this->status = Status::active();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAtDate(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Login
     */
    public function getLogin(): Login
    {
        return $this->login;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Age
     */
    public function getAge(): Age
    {
        return $this->age;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * @return ConfirmToken|null
     */
    public function getSignUpConfirmToken(): ?ConfirmToken
    {
        return $this->signUpConfirmToken;
    }
}