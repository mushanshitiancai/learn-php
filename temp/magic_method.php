<?php 

class A{
	private $one;

	function __set($name,$value){
		echo "set:";
		var_dump($name,$value);
	}

	function __get($name){
		echo "get:";
		var_dump($name);

		return 'fuck';
	}
}

$a = new A();
var_dump($a->one);
var_dump($a->one = 100);