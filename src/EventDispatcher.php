<?php

namespace App;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public array $dispatchedEvents = [];

    public function dispatch($event, ?string $eventName = null): object
    {
        $this->dispatchedEvents[] = $eventName;

        return $event;
    }
}