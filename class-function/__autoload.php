<?php 

function __autoload($class){
	echo "1. __autoload $class\n";
}

function __autoload($class){
	echo "2. __autoload $class\n";

	if($class == 'MyClass'){
		require("../common/MyClass.php");
	}
}

$obj = new MyClass();
$obj = new MyClass();