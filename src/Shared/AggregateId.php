<?php

namespace App\Shared;

interface AggregateId
{
    public static function fromString(int $taskId);

    public function __toString();

    public function equals(AggregateId $other);
}
