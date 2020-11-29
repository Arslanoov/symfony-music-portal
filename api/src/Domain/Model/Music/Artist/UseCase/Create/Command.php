<?php

declare(strict_types=1);

namespace Domain\Model\Music\Artist\UseCase\Create;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $id;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="16")
     */
    public string $login;

    public function __construct(string $id, string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }
}
