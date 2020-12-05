<?php

declare(strict_types=1);

namespace Test\Builder;

use Domain\Model\Music\Artist\Artist;
use Domain\Model\Music\Artist\Id;
use Domain\Model\Music\Artist\Login;

final class ArtistBuilder
{
    private Id $id;
    private Login $login;

    public function __construct()
    {
        $this->id = Id::asUuid4();
        $this->login = new Login("Artist login");
    }

    public function withId(string $id): self
    {
        $builder = clone $this;
        $builder->id = new Id($id);
        return $builder;
    }

    public function withLogin(string $login): self
    {
        $builder = clone $this;
        $builder->login = new Login($login);
        return $builder;
    }

    public function build(): Artist
    {
        return new Artist(
            $this->id,
            $this->login
        );
    }
}
