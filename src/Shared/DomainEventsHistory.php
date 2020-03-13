<?php

namespace App\Shared;

class DomainEventsHistory extends DomainEvents
{
    /**
     * @var int
     */
    private $aggregateId;

    /**
     * @param int   $aggregateId
     * @param DomainEvent[] $events
     */
    public function __construct(int $aggregateId, $events)
    {
        $this->aggregateId = $aggregateId;

        parent::__construct($events);
    }

    public function getAggregateId(): int
    {
        return $this->aggregateId;
    }
}
