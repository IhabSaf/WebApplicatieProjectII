<pre>
<?php


class A{}
class B{
    public function demo():String {
        return "Hallo Ihab";
    }
}

class C{}

class Test{


    public function __construct(public A $a, public B $b){

    }

    public function getFoo():String {
        return $this->b->demo();
    }

}

$reflection = new ReflectionClass(Test::class);

//var_dump($reflection->getConstructor()->getParameters());


$list_para = [];
foreach ($reflection->getConstructor()->getParameters() as $test_class_parameter){
    $tmp = new ReflectionClass($test_class_parameter->getType()->getName());
    $list_para[] = $tmp->newInstance();
}
var_dump($list_para );

$test = $reflection->newInstanceArgs($list_para);
var_dump($test);

print ($test->getFoo());
