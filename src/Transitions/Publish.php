<?php

namespace App\Transitions;

use App\Traits\BaseTransition;

class Publish
{
    use BaseTransition;

    public function __invoke($event)
    {
        return $this->transition($event);    
    }
}