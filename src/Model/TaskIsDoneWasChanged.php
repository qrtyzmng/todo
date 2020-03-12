<?php

namespace App\Model;

use App\Shared\DomainEvent;

class TaskIsDoneWasChanged implements DomainEvent
{
    /**
     * @var TaskId
     */
    private $taskId;

    /**
     * @var boolean
     */
    private $isDone;

    public function __construct($taskId, $isDone)
    {
        $this->taskId = $taskId;
        $this->isDone = $isDone;
    }

    public function getAggregateId(): int
    {
        return $this->taskId;
    }

    /**
     * 
     * @return bool|null
     */
    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }
    
}
