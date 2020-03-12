<?php

namespace App\Query\Handler;

use App\Query\TaskQuery;

class TasksQueryHandler extends AbstractQueryHandler
{
    public function __invoke(TaskQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
