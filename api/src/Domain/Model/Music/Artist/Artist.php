<?php

declare(strict_types=1);

namespace Domain\Model\Music\Artist;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Artist
 * @package Domain\Model\Music\Artist
 * @ORM\Entity
 * @ORM\Table(name="music_artists")
 */
final class Artist
{
    /**
     * @var Id
     * @ORM\Id()
     * @ORM\Column(type="music_artist_id")
     */
    private Id $id;
    /**
     * @var Login
     * @ORM\Column(type="music_artist_login")
     */
    private Login $login;

    public function __construct(Id $id, Login $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getLogin(): Login
    {
        return $this->login;
    }
}
