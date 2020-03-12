<?php

namespace App\Shared;

abstract class AggregateRoot implements RecordsEvents
{
    /**
     * @var array|DomainEvent[]
     */
    private $recordedEvents = [];

    public function getRecordedEvents(): DomainEvents
    {
        return new DomainEvents($this->recordedEvents);
    }

    public function clearRecordedEvents()
    {
        $this->recordedEvents = [];
    }

    public function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
    }

    abstract public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory);
}