<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

final class User
{
    private Id $id;

    /**
     * User constructor.
     * @param Id $id
     */
    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
}