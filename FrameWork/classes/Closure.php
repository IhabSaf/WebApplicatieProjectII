<?php
//function opdracht1($a, $b){
//    $n = strlen($a) <=> strlen($b);
//    return $n;
//
//}

$array = ["Ihab", "Noa", "EveryOne", "Soorttt"];
usort($array, fn($a, $b) => $a <=> $b);

var_dump($array);


