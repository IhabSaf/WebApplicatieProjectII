<?php
namespace FrameWork\HTTP;
class Kernel {
    private $eventdispatcher;
    private $resolveController;

    public function __construct($eventdispatcher, $resolveController)
    {
        $this->eventdispatcher = $eventdispatcher;
        $this->resolveController = $resolveController;

    }
}