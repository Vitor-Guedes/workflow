<?php

namespace App\Traits;

trait BaseTransition
{
    public function transition($event) 
    {
        echo json_encode([
            get_class($this) => __FUNCTION__
        ]) . PHP_EOL;

        $post = $event->getSubject();

        $to = $event->getTransition()->getTos()[0];
        $post->setStatus($to);
        $post->update();

        echo $post->toJson() . PHP_EOL;    
    }
}