<?php

namespace App\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

abstract class AbstractCommandHandler implements MessageHandlerInterface
{
    /**
     *
     * @var EntityManagerInterface 
     */
    protected $entityManager;
    
    /**
     *
     * @var TaskRepository 
     */
    protected $taskRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }
}
