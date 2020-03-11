<?php

namespace App\Query;

class TaskQuery
{
    private $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): int
    {
        return $this->id;
    }
}
