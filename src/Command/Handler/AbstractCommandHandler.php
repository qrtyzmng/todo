<?php

namespace App\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Infrastructure\Persistence\MySQLEventStore;

abstract class AbstractCommandHandler implements MessageHandlerInterface
{
    /**
     *
     * @var EntityManagerInterface 
     */
    protected $entityManager;
    
    /**
     *
     * @var MySQLEventStore 
     */
    protected $store;

    public function __construct(EntityManagerInterface $em, MySQLEventStore $store)
    {
        $this->entityManager = $em;
        $this->store = $store;
    }
}
