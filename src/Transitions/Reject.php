<?php

namespace App\Transitions;

use App\Traits\BaseTransition;

class Reject
{
    use BaseTransition;

    public function __invoke($event)
    {
        return $this->transition($event);    
    }
}