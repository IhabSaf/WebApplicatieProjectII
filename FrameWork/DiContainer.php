<?php
namespace FrameWork;
use ReflectionClass;

class DiContainer
{
    public function __construct() {}
    public function createApp(string $class = "FrameWork\App", $constructorParams = []): object
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $className = explode('\\', $reflection->getName())[count(explode('\\', $reflection->getName())) - 1];
        if ($constructor) {
            foreach ($constructor->getParameters() as $parameter) {
                $parameterName = $parameter->getName();
                $parameterType = $parameter->getType()->getName();
                $arguments = [];

                foreach ($parameter->getAttributes() as $attribute) {
                    $attributeName = explode('\\', $attribute->getName())[count(explode('\\', $attribute->getName())) - 1];
                    if ($attributeName == "Argument") {
                        $arguments += $attribute->getArguments();
                    }
                    if ($attributeName == "Service") {
                        $parameterType = $attribute->getArguments()[0];
                    }
                }
                if (!array_key_exists($parameterName, $constructorParams)) {
                    $constructorParams[$parameterName] = $this->createApp($parameterType, $arguments);
                }
            }
        }
        if ($className == "Request") {
            $method = $reflection->getMethod('makeWithGlobals');
            return $method->invoke($reflection->newInstanceWithoutConstructor());
        }
        return $reflection->newInstance(...$constructorParams);
    }

    public function createClass(string $name): object
    {
        return $this->createApp($name);
    }
}