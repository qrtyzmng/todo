<?php

namespace App\Query\Handler;

use App\Query\TaskQuery;

class ProductQueryHandler extends AbstractQueryHandler
{
    public function __invoke(TaskQuery $query)
    {
        return $this->repository->find($query->getId());
    }
}
