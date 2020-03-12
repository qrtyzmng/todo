<?php

namespace App\Shared;

interface EventStore
{
    public function append(DomainEvents $events);
}
