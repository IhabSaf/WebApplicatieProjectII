<?php

class Response
{
    private $statusCode;
    private $headers;
    private $body;



    public function __construct($body,$header=[], $statusCode=200)
    {
        $this-> statusCode = $statusCode;
        $this-> headers = $header;
        $this-> body =$body;
    }

    public function addHeader($name, $value){
        $this->headers[$name][] = $value;
    }

    public function setHeader($name, $value){
        $this->headers[$name] = [(String) $value];
    }


}








