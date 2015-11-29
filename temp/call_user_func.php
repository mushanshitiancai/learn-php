<?php 

class A{
	static function static_function($a,$b){
		return $a+$b;
	}
}

var_dump(call_user_func('A::static_function',1,2));
var_dump(call_user_func_array('A::static_function',array(1,2)));