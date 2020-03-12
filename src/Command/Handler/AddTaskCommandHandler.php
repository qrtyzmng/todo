<?php

namespace App\Command\Handler;

use App\Command\AddTaskCommand;
use App\Entity\Task;
use App\Model\TaskWasCreated;

class AddTaskCommandHandler extends AbstractCommandHandler
{
    public function __invoke(AddTaskCommand $command)
    {       
        $newTask = Task::create($command);
               
        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->persist($newTask);
            $this->entityManager->flush();
            $newTask->recordThat(new TaskWasCreated($newTask->getId(), $newTask->getName(), $newTask->getIsDone(), $newTask->getCreatedAt(), $newTask->getUpdatedAt()));  
            $this->store->append($newTask->getRecordedEvents());
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
        }
    }
}
