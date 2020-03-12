<?php

namespace App\Command;


class UpdateTaskCommand
{
    /**
     * @var int
     */
    private $id;
    
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
    private $updatedAt;

    /**
     * 
     * @param int $id
     * @param string $name
     * @param bool $isDone
     */
    public function __construct(int $id, string $name, bool $isDone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isDone = $isDone;
        $this->updatedAt = new \DateTime('now');
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
