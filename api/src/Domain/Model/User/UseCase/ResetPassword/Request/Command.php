<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\ResetPassword\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $login;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;

    /**
     * Command constructor.
     * @param string $login
     * @param string $email
     */
    public function __construct(string $login, string $email)
    {
        $this->login = $login;
        $this->email = $email;
    }
}
