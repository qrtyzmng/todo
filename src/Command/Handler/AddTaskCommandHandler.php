<?php

namespace App\Command\Handler;

use App\Command\AddTaskCommand;
use App\Entity\Task;

class AddTaskCommandHandler extends AbstractCommandHandler
{
    public function __invoke(AddTaskCommand $command)
    {
        $newTask = new Task();
        $newTask->setName($command->getName());
        $newTask->setIsDone($command->getIsDone());
        $newTask->setCreatedAt($command->getCreatedAt());
        $newTask->setUpdatedAt($command->getUpdatedAt());
            
        $this->entityManager->persist($newTask);
        $this->entityManager->flush();
    }
}
