<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song;

use App\Domain\Model\Music\Song\Event\SongCreated;
use App\Domain\Model\Music\Song\Type;
use DateTimeImmutable;
use Domain\Model\AggregateRoot;
use Domain\Model\EventsTrait;
use Domain\Model\Music\Artist\Artist;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Song
 * @package Domain\Model\Music\Song
 * @ORM\Entity()
 * @ORM\Table(name="music_songs")
 */
final class Song implements AggregateRoot
{
    use EventsTrait;

    /**
     * @var Id
     * @ORM\Id()
     * @ORM\Column(type="music_song_id")
     */
    private Id $id;
    /**
     * @var Artist
     * @ORM\ManyToOne(targetEntity="Domain\Model\Music\Artist\Artist", inversedBy="songs")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false)
     */
    private Artist $artist;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="date_immutable", name="uploaded_at")
     */
    private DateTimeImmutable $uploadedAt;
    /**
     * @var Name
     * @ORM\Column(type="music_song_name", length=32)
     */
    private Name $name;
    /**
     * @var File
     * @ORM\Column(type="music_song_file")
     */
    private File $file;
    /**
     * @var Info
     * @ORM\Embedded(class="Domain\Model\Music\Song\Info", columnPrefix="info_")
     */
    private Info $info;
    /**
     * @var Statistic
     * @ORM\Embedded(class="Domain\Model\Music\Song\Statistic", columnPrefix="statistic_")
     */
    private Statistic $statistic;
    /**
     * @var Status
     * @ORM\Column(type="music_song_status")
     */
    private Status $status;
    /**
     * @var Type
     * @ORM\Column(type="music_song_type")
     */
    private Type $type;

    public function __construct(
        Id $id,
        Artist $artist,
        DateTimeImmutable $uploadedAt,
        Name $name,
        File $file,
        Info $info,
        Statistic $statistic,
        Status $status,
        Type $type
    ) {
        $this->id = $id;
        $this->artist = $artist;
        $this->uploadedAt = $uploadedAt;
        $this->name = $name;
        $this->file = $file;
        $this->info = $info;
        $this->statistic = $statistic;
        $this->status = $status;
        $this->type = $type;
    }

    public static function single(Artist $artist, Name $name, File $file, Info $info): self
    {
        $song = new self(
            Id::asUuid4(),
            $artist,
            new DateTimeImmutable(),
            $name,
            $file,
            $info,
            Statistic::new(),
            Status::draft(),
            Type::single()
        );

        $song->recordEvent(new SongCreated(
            $song->getId()->getValue(),
            $song->getArtist()->getId()->getValue(),
            $name->getValue()
        ));

        return $song;
    }

    public function changeName(Name $name): void
    {
        $this->name = $name;
    }

    public function changeInfo(Info $info): void
    {
        $this->info = $info;
    }

    public function listen(): void
    {
        $this->statistic = new Statistic(
            $this->statistic->getListensCount() + 1,
            $this->statistic->getDownloadsCount(),
            $this->statistic->getMonthListensCount() + 1,
            $this->statistic->getMonthDownloadsCount()
        );
    }

    public function download(): void
    {
        $this->statistic = new Statistic(
            $this->statistic->getListensCount(),
            $this->statistic->getDownloadsCount() + 1,
            $this->statistic->getMonthListensCount(),
            $this->statistic->getMonthDownloadsCount() + 1
        );
    }

    public function clearMonthStatistic(): void
    {
        $this->statistic = Statistic::withClearedMonthStatistics($this->statistic);
    }

    public function decline(): void
    {
        $this->status = Status::draft();
    }

    public function sendToModeration(): void
    {
        $this->status = Status::inModeration();
    }

    public function approve(): void
    {
        $this->status = Status::approved();
    }

    public function isDraft(): bool
    {
        return $this->getStatus()->isDraft();
    }

    public function isInModeration(): bool
    {
        return $this->getStatus()->isInModeration();
    }

    public function isApproved(): bool
    {
        return $this->getStatus()->isApproved();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    public function getUploadedAtDate(): DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }

    public function getStatistic(): Statistic
    {
        return $this->statistic;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}
