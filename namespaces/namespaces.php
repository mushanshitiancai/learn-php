<?php 
namespace A{
	use aaaaaaaaaa as C;

$a = new C();
var_dump($a);
}
 
namespace {
	function __autoload($name){
	var_dump($name);
}
}