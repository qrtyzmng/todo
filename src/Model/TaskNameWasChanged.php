<?php

namespace App\Model;

use App\Shared\DomainEvent;

class TaskNameWasChanged implements DomainEvent
{
    /**
     * @var TaskId
     */
    private $taskId;

    /**
     * @var string
     */
    private $name;

    public function __construct($taskId, $name)
    {
        $this->taskId = $taskId;
        $this->name = $name;
    }

    public function getAggregateId(): int
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
}
