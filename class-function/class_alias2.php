<?php
error_reporting(E_ALL);

// class_alias的autoload参数的效果

function __autoload($class){
	echo "__autoload $class\n";

	if($class == 'MyClass'){
		require("../common/MyClass.php");
	}else if($class == 'My'){
		require("../common/My.php");
	}
}

class_alias('MyClass','My',false);

$my = new My();
$myclass = new MyClass();

var_dump($my == $myclass);             
var_dump($my === $myclass);            
var_dump($my instanceof $myclass);     

var_dump($my instanceof My);           
var_dump($my instanceof MyClass);      

var_dump($myclass instanceof My);      
var_dump($myclass instanceof MyClass); 
