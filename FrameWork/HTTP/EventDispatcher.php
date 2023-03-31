<?php
namespace FrameWork\Class;
class EventDispatcher
{

    private array $listener = [] ;


    public function __constructot()
    {

    }

    public function addListener(string $eventName, string $listener)
    {
        $this->listener[]=[$eventName,$listener];
    }
    public function disatch(object $event, string $eventName = null)
    {

        if($this->listener[$eventName]){

        }

    }

}