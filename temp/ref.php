<?php

/**
 * 互相引用的变量间，完全一样。不管给一个赋什么值，另外一个都变化
 */
class A{}

/*
$a = 10;
$b = &$a;

var_dump($b);

$a = 'a';

var_dump($b);

$b = new A();

var_dump($a);
*/

/**
 * foreach中使用引用可以修改数组中的值
 */
/*
$a = array(new A(),new A());
foreach ($a as $i => &$v) {
	$v = '1';
}

var_dump($a);
*/

/**
 * 
 */
/*
$arr = array(1,2,3);
$arr2 = array('a','b','c');

foreach($arr as &$v){
}
foreach($arr2 as $v){
}

var_dump($arr);
var_dump($arr2);


$arr = array(1,2,3);
foreach($arr as $v){
}
var_dump($v);
*/

var_dump($i);
for ($i=0; $i < 3; $i++) { 
	
}
var_dump($i);







