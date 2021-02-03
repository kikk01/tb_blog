<?php

namespace App\Infrastructure\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TransferEvent extends Event
{

    const NAME = "app.event.transfer";

    private object $originalData;

    protected object $data;

    public function __construct(object $originalData, object $data)
    {
        $this->originalData = $originalData;
        $this->data = $data;
    }

    /**
     * Get the value of originalData
     */ 
    public function getOriginalData(): object
    {
        return $this->originalData;
    }

    /**
     * Get the value of data
     */ 
    public function getData(): object
    {
        return $this->data;
    }
}