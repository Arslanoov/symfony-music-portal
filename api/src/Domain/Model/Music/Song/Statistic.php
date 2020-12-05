<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Statistic
 * @package Domain\Model\Music\Song
 * @ORM\Embeddable()
 */
final class Statistic
{
    /**
     * @var int
     * @ORM\Column(type="integer", name="listens_count")
     */
    private int $listensCount;
    /**
     * @var int
     * @ORM\Column(type="integer", name="downloads_count")
     */
    private int $downloadsCount;

    /**
     * @var int
     * @ORM\Column(type="integer", name="month_listens_count")
     */
    private int $monthListensCount;
    /**
     * @var int
     * @ORM\Column(type="integer", name="month_downloads_count")
     */
    private int $monthDownloadsCount;

    public function __construct(
        int $listensCount,
        int $downloadsCount,
        int $monthListensCount,
        int $monthDownloadsCount
    ) {
        Assert::greaterThanEq($listensCount, 0, "Incorrect listens count value.");
        $this->listensCount = $listensCount;
        Assert::greaterThanEq($downloadsCount, 0, "Incorrect downloads count value.");
        $this->downloadsCount = $downloadsCount;
        Assert::greaterThanEq($monthListensCount, 0, "Incorrect month listens count value.");
        $this->monthListensCount = $monthListensCount;
        Assert::greaterThanEq($monthDownloadsCount, 0, "Incorrect month downloads count value.");
        $this->monthDownloadsCount = $monthDownloadsCount;
    }

    public static function new(): self
    {
        return new self(0, 0, 0, 0);
    }

    public static function withClearedMonthStatistics(Statistic $statistic): self
    {
        return new self(
            $statistic->getListensCount(),
            $statistic->getDownloadsCount(),
            0,
            0
        );
    }

    public function getListensCount(): int
    {
        return $this->listensCount;
    }

    public function getDownloadsCount(): int
    {
        return $this->downloadsCount;
    }

    public function getMonthListensCount(): int
    {
        return $this->monthListensCount;
    }

    public function getMonthDownloadsCount(): int
    {
        return $this->monthDownloadsCount;
    }

    public function isEmpty(): bool
    {
        return
            $this->listensCount === 0 &&
            $this->downloadsCount === 0 &&
            $this->monthListensCount === 0 &&
            $this->monthDownloadsCount === 0
        ;
    }

    public function isMonthEmpty(): bool
    {
        return
            $this->monthListensCount === 0 &&
            $this->monthDownloadsCount === 0
        ;
    }
}
