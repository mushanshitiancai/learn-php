<?php

function __autoload($class){
	echo "__autoload $class\n";

	if($class == 'MyClass'){
		require("../common/MyClass.php");
	}
}

class_alias('MyClass','My');

$my = new My();
$myclass = new MyClass();

var_dump($my == $myclass);              //true
var_dump($my === $myclass);             //false
var_dump($my instanceof $myclass);      //true

var_dump($my instanceof My);            //true
var_dump($my instanceof MyClass);       //true

var_dump($myclass instanceof My);       //true
var_dump($myclass instanceof MyClass);  //true
