<?php

namespace App\Command;


class AddTaskCommand
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDone;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
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
