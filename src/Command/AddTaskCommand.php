<?php

namespace App\Command;


class AddTaskCommand
{
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

    /**
     * 
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->isDone = false;
        $currentDate = new \DateTime('now');
        $this->createdAt = $currentDate;
        $this->updatedAt = $currentDate;
    }

    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * 
     * @return bool
     */
    public function getIsDone(): bool
    {
        return $this->isDone;
    }
    
    /**
     * 
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    
    /**
     * 
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
