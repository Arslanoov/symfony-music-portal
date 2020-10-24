<?php

declare(strict_types=1);

namespace Domain\Model;

trait EventsTrait
{
    private array $recordedEvents = [];

    public function recordEvent(object $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}