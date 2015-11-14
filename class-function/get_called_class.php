<?php

error_reporting(E_ALL);

class A{
	static function func(){
		var_dump(get_called_class());
	}
}

class B extends A{}

A::func();
B::func();
var_dump(get_called_class());