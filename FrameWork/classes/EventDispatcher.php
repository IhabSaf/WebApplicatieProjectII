<?php

class EventDispatcher
{
    private array $listener = [] ;

    public function __constructot()
    {

    }

    public function addListener(string $eventName, string $listener){

        $this->listener[]=[$eventName,$listener];


    }
    public function disatch(object $event, string $eventName = null){

        if($this->listener[$eventName]){
            $this->listener[$eventName]->handle($event);

        }


    }

    public function getListeners(string $eventName = null){
        return $this->listener[$eventName];
    }


}
