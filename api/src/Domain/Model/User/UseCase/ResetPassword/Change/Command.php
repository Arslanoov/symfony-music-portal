<?php

declare(strict_types=1);

namespace Domain\Model\User\UseCase\ResetPassword\Change;

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
     */
    public string $token;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="6")
     */
    public string $newPassword;

    /**
     * Command constructor.
     * @param string $login
     * @param string $token
     * @param string $newPassword
     */
    public function __construct(string $login, string $token, string $newPassword)
    {
        $this->login = $login;
        $this->token = $token;
        $this->newPassword = $newPassword;
    }
}
