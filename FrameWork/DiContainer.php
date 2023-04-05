<?php
namespace FrameWork;
use ReflectionClass;

class DiContainer
{
    private int $count = 0;
    public function __construct() {}
    public function createDefaultClass(string $class, $constructorParams = [])
    {
        if($class == 'string'){
            return '';
        } elseif($class == 'int'){
            return 0;
        } elseif($class == 'array'){
            return [];
        }
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $name = explode('\\', $reflection->getName())[count(explode('\\', $reflection->getName())) - 1];
        if($name == "App") {
            $constructor = $reflection->getMethod("handle");
        }
        if($name == "Request"){
            return $reflection->getMethod('makeWithGlobals');
        }
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType()->getName();
            foreach ($parameter->getAttributes() as $attribute){
                $attributeName = explode('\\', $attribute->getName())[count(explode('\\', $attribute->getName())) - 1];
                if($attributeName == "Service"){
                    $type = $attribute->getArguments()[0];
                }
            }
            if (!array_key_exists($parameter->getName(), $constructorParams)) {
                $constructorParams[$parameter->getName()] = $this->createDefaultClass($type);
            }
        }
        var_dump($this->count);
        var_dump($constructorParams);
        $this->count += 1;
        return $reflection->newInstance(...$constructorParams);
    }
}