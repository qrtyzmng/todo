<?php

namespace App\Command\Handler;

use App\Command\UpdateTaskCommand;
use App\Entity\Task;

class UpdateTaskCommandHandler extends AbstractCommandHandler
{
    public function __invoke(UpdateTaskCommand $command)
    {       
        $task = $this->entityManager->getRepository(Task::class)->find($command->getId());
               
        $this->entityManager->beginTransaction();
        try {
            $task->changeName($command->getName());
            $task->changeIsDone($command->getIsDone());
            $task->changeUpdatedAt($command->getUpdatedAt());
            
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            $this->store->append($task->getRecordedEvents());
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
        }
    }
}
