<?php

namespace App\Workflows\Listeners;

class Confirm
{
    public function __invoke($event)
    {
        $customWorkflow = $event->getSubject();
        $to = $event->getTransition()->getTos()[0];
        $customWorkflow->status = $to;
        $customWorkflow->update();
    }
}