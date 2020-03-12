<?php

namespace App\Shared;

interface DomainEvent
{
    public function getAggregateId(): int;
}
