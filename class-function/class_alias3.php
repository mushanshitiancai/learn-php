<?php
error_reporting(E_ALL);

// 可以定义和别名同名的类么？

function __autoload($class){
	echo "__autoload $class\n";

	if($class == 'MyClass'){
		require("../common/MyClass.php");
	}
}

class My{
	function __construct(){
		echo "this My::__construct\n";
	}
}

class_alias('MyClass','My',false);

$my = new My();
