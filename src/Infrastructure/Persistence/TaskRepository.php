<?php

namespace App\Infrastructure\Persistence;

use SfCQRSDemo\Model\Product\Product;
use SfCQRSDemo\Model\Product\ProductProjection;
use App\Model\TaskRepository as TaskRepositoryPort;
use SfCQRSDemo\Shared\AggregateId;
use SfCQRSDemo\Shared\EventStore;
use SfCQRSDemo\Shared\RecordsEvents;

class TaskRepository implements TaskRepositoryPort
{
    /**
     * @var EventStore
     */
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function add(RecordsEvents $aggregate)
    {
        $recordedEvents = $aggregate->getRecordedEvents();
        $this->eventStore->append($recordedEvents);
        $aggregate->clearRecordedEvents();
    }

    public function get(AggregateId $id): RecordsEvents
    {
        $events = $this->eventStore->get($id);

        return Product::reconstituteFromHistory($events);
    }
}
