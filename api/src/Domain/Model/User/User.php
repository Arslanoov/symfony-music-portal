<?php

declare(strict_types=1);

namespace Domain\Model\User;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Domain\Model\AggregateRoot;
use Domain\Model\EventsTrait;
use Domain\Model\User\Event\UserSignedUp;

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
     * User constructor.
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param Name $name
     * @param Login $login
     * @param Email $email
     * @param Age $age
     * @param Password $password
     */
    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        Name $name,
        Login $login,
        Email $email,
        Age $age,
        Password $password
    ) {
        $this->id = $id;
        $this->createdAt = $date;
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->age = $age;
        $this->password = $password;

        $this->recordEvent(new UserSignedUp(
            $id->getValue(),
            $login->getValue(),
            $email->getValue()
        ));
    }

    public static function signUpByEmail(
        Id $id,
        Name $name,
        Login $login,
        Email $email,
        Age $age,
        Password $password
    ): self {
        return new self(
            $id,
            new DateTimeImmutable(),
            $name,
            $login,
            $email,
            $age,
            $password
        );
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
}