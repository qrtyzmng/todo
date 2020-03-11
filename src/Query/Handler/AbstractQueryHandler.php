<?php

namespace App\Query\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Repository\TaskRepository;

abstract class AbstractQueryHandler implements MessageHandlerInterface
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }
}
