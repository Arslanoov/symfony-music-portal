<?php

declare(strict_types=1);

namespace Test\Builder;

use DateTimeImmutable;
use Domain\Model\User\Age;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Email;
use Domain\Model\User\Id;
use Domain\Model\User\Login;
use Domain\Model\User\Name;
use Domain\Model\User\Password;
use Domain\Model\User\Status;
use Domain\Model\User\User;
use Ramsey\Uuid\Uuid;

final class UserBuilder
{
    public Id $id;
    public DateTimeImmutable $createdAt;
    public Name $name;
    public Login $login;
    public Email $email;
    public Age $age;
    public Password $password;
    public Status $status;
    public ConfirmToken $signUpConfirmToken;

    public function __construct()
    {
        $this->id = new Id(Uuid::uuid4()->toString());
        $this->createdAt = new DateTimeImmutable();
        $this->name = new Name('Name', 'Name');
        $this->login = new Login('BuildUser');
        $this->email = new Email('build@app.test');
        $this->age = new Age(32);
        $this->password = new Password('secret');
        $this->status = Status::draft();
        $this->signUpConfirmToken = new ConfirmToken('secret', new DateTimeImmutable());
    }

    public function withId(string $id): self
    {
        $builder = clone $this;
        $builder->id = new Id($id);
        return $builder;
    }

    public function withCreatedAtDate(DateTimeImmutable $date): self
    {
        $builder = clone $this;
        $builder->createdAt = $date;
        return $builder;
    }

    public function withNames(string $first, string $last): self
    {
        $builder = clone $this;
        $builder->name = new Name($first, $last);
        return $builder;
    }

    public function withLogin(string $login): self
    {
        $builder = clone $this;
        $builder->login = new Login($login);
        return $builder;
    }

    public function withEmail(string $email): self
    {
        $builder = clone $this;
        $builder->email = new Email($email);
        return $builder;
    }

    public function withAge(int $age): self
    {
        $builder = clone $this;
        $builder->age = new Age($age);
        return $builder;
    }

    public function withPassword(string $password): self
    {
        $builder = clone $this;
        $builder->password = new Password($password);
        return $builder;
    }

    public function withStatus(string $status): self
    {
        $builder = clone $this;
        $builder->status = new Status($status);
        return $builder;
    }

    public function active(): self
    {
        $builder = clone $this;
        $builder->status = Status::active();
        return $builder;
    }

    public function draft(): self
    {
        $builder = clone $this;
        $builder->status = Status::draft();
        return $builder;
    }

    public function withSignUpConfirmToken(string $token, DateTimeImmutable $expireDate): self
    {
        $builder = clone $this;
        $builder->signUpConfirmToken = new ConfirmToken($token, $expireDate);
        return $builder;
    }

    public function build(): User
    {
        return new User(
            $this->id,
            $this->createdAt,
            $this->name,
            $this->login,
            $this->email,
            $this->age,
            $this->password,
            $this->status,
            $this->signUpConfirmToken
        );
    }
}