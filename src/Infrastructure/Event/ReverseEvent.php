<?php

namespace App\Infrastructure\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ReverseEvent extends Event
{
    const NAME = "app.event.reverse";

    protected object $data;

    protected object $originalData;

    public function __construct(object $data, object $originalData)
    {
        $this->data = $data;
        $this->originalData = $originalData;
    }



    /**
     * Get the value of data
     */ 
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * Get the value of originalData
     */ 
    public function getOriginalData(): object
    {
        return $this->originalData;
    }
}