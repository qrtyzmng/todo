<?php

namespace App\Model;

use App\Shared\DomainEvent;

class TaskWasCreated implements DomainEvent
{
    /**
     * @var TaskId
     */
    private $taskId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $isDone;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct($taskId, $name, $isDone, $createdAt, $updatedAt)
    {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->isDone = $isDone;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
    
    /**
     * 
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    /**
     * 
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
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
