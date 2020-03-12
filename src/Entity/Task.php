<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Shared\AggregateRoot;
use App\Shared\DomainEventsHistory;
use App\Command\AddTaskCommand;
use App\Model\TaskNameWasChanged;
use App\Model\TaskIsDoneWasChanged;
use App\Model\TaskUpdatedAtWasChanged;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task extends AggregateRoot
{
    const NUM_ITEMS = 10;
    
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @param \App\Entity\AddTaskCommand $command
     * @return \App\Entity\Task
     */
    public static function create(AddTaskCommand $command): Task
    {
        $newTask = new Task();
        $newTask->setName($command->getName());
        $newTask->setIsDone($command->getIsDone());
        $newTask->setCreatedAt($command->getCreatedAt());
        $newTask->setUpdatedAt($command->getUpdatedAt());
        return $newTask;
    }
    
    private static function createEmptyTaskWithId(AggregateId $taskId)
    {
        $task = new Task();
        $task->setId($taskId);
        return $task;
    }

    /**
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * 
     * @param int $id
     */
    protected function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function changeName(string $newName)
    {
        if ($newName === $this->name) {
            return;
        }
        
        $this->setName($newName);
        $this->recordThat(
            new TaskNameWasChanged($this->id, $newName)
        );
    }
    
    /**
     * 
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * 
     * @return bool|null
     */
    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }
    
    /**
     * 
     * @param bool|null $isDone
     */
    public function setIsDone(?bool $isDone)
    {
        $this->isDone = $isDone;
    }
    
    public function changeIsDone(bool $isDone)
    {
        if ($isDone === $this->isDone) {
            return;
        }
        $this->setIsDone($isDone);
        $this->recordThat(
            new TaskIsDoneWasChanged($this->id, $isDone)
        );
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
     * @param \DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
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
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    public function changeUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        if ($updatedAt === $this->updatedAt) {
            return;
        }
        $this->setUpdatedAt($updatedAt);
        $this->recordThat(
            new TaskUpdatedAtWasChanged($this->id, $updatedAt)
        );
    }
    
    public static function reconstituteFromHistory(DomainEventsHistory $eventsHistory)
    {
        $task = static::createEmptyTaskWithId($eventsHistory->getAggregateId());

        foreach ($eventsHistory as $event) {
            $task->apply($event);
        }

        return $task;
    }
}
