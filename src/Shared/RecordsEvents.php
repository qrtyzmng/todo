<?php

namespace App\Shared;

interface RecordsEvents
{
    public function getRecordedEvents(): DomainEvents;

    public function clearRecordedEvents();
}
