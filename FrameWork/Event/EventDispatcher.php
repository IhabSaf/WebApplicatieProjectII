<?php
namespace FrameWork\Event;

use src\Controller\MainController;

class EventDispatcher
{
    private array $listener = [];
    public function __construct()
    {

    }

    public function addListener(string $eventName, string $listener): void
    {
        if(isset($this->listener[$eventName])) {
            $this->listener[$eventName][]=$listener;
        } else{
            $this->listener[$eventName]=[$listener];
        }
    }
    public function dispatch(object $event, string $eventName): void
    {
        if($this->listener[$eventName]){
            foreach ($this->listener[$eventName] as $listener){
                [new $listener, "handle"]($event);
            }
        }
    }

    public function getListeners(string $eventName): string
    {
        return $this->listener[$eventName];
    }
}
