<?php
namespace FrameWork\HTTP;
use FrameWork\Event\EventDispatcher;

class Kernel {

    public function __construct(private EventDispatcher $eventdispatcher, private \ControllerResolver $controllerResolver)
    {
    }
}