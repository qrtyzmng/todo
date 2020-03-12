<?php

namespace App\Query\Handler;

use App\Query\TasksCountQuery;

class TasksCountHandler extends AbstractQueryHandler
{
    public function __invoke(TasksCountQuery $query)
    {
        return $this->repository->countElements($query);
    }
}
