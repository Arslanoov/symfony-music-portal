<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Name
 * @package Domain\Model\User
 * @ORM\Embeddable()
 */
final class Name
{
    /**
     * @var string
     * @ORM\Column(type="string", name="first", length=32)
     */
    private string $firstName;
    /**
     * @var string
     * @ORM\Column(type="string", name="last", length=32)
     */
    private string $lastName;

    /**
     * Name constructor.
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        Assert::lengthBetween($firstName, 2, 32, 'User first name must be between 2 and 32 chars length.');
        $this->firstName = $firstName;
        Assert::lengthBetween($lastName, 2, 32, 'User last name must be between 2 and 32 chars length.');
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function isEqualTo(Name $name): bool
    {
        return $this->firstName === $name->getFirstName() &&
            $this->lastName === $name->getLastName();
    }
}
