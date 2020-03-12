<?php
namespace App\Query\Handler;

use App\Query\PagingTasksQuery;

class PagingTasksQueryHandler extends AbstractQueryHandler
{
    public function __invoke(PagingTasksQuery $query)
    {
        return $this->repository->fetchAll($query->getPage(), $query->getPerPage());
    }
}
