<?php

namespace App\Infrastructure\Persistence;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use App\Shared\DomainEvents;
use App\Shared\EventStore;
use JMS\Serializer\SerializerInterface;

class MySQLEventStore implements EventStore
{
    const TABLE_NAME = 'events';

    protected $connection;

    protected $serializer;

    public function __construct(Connection $connection, SerializerInterface $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    public function append(DomainEvents $events)
    {
        $stmt = $this->connection->prepare(
            sprintf('INSERT INTO %s (`aggregate_id`, `event_name`, `created_at`, `payload`) VALUES (:aggregateId, :eventName, :createdAt, :payload)', static::TABLE_NAME)
        );
        
        /** @var DomainEvent $event */
        foreach ($events as $event) {    
            $stmt->execute([
                ':aggregateId' => (int) $event->getAggregateId(),
                ':eventName' => get_class($event),
                ':createdAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                ':payload' => $this->serializer->serialize($event, 'json'),
            ]);
        }
    }
}
