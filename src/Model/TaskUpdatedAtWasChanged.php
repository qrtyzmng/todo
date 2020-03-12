<?php

namespace App\Model;

use App\Shared\DomainEvent;

class TaskUpdatedAtWasChanged implements DomainEvent
{
    /**
     * @var TaskId
     */
    private $taskId;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct($taskId, $updatedAt)
    {
        $this->taskId = $taskId;
        $this->updatedAt = $updatedAt;
    }

    public function getAggregateId(): int
    {
        return $this->taskId;
    }

    /**
     * 
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    
}
