<?php

namespace App\Workflows\Listeners;

class Invalidate
{
    public function __invoke($event)
    {
        $customWorkflow = $event->getSubject();
        $to = $event->getTransition()->getTos()[0];
        $customWorkflow->status = $to;
        $customWorkflow->update();
    }
}