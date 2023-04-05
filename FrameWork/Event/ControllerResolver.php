<?php
namespace FrameWork\Event;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;

class ControllerResolver
{
    public function __construct(){}

    public function getController(IRequest $request, Iresponse $response): IResponse
    {
        if($request->getPathInfo() == '/'){
            $response->addHeader('_controller', 'MainController');
        }
        $response->addHeader('_controller', 'MainController');
        return $response;
    }
}