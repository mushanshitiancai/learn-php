<?php

error_reporting(E_ALL);

class A{
	public $public_var;
	protected $protected_var;
	private $private_var;

	static public $static_public_var;
	static protected $static_protected_var;
	static private $static_private_var;

	public function public_func(){
		var_dump(property_exists($this, 'private_var'));
	}

	private function private_func(){
		var_dump(property_exists($this, 'private_var'));
	}

	static public function static_public_func(){
		var_dump(property_exists('A', 'private_var'));
	}
}

var_dump(property_exists('A','public_var'));         //true
var_dump(property_exists('A','protected_var'));      //true
var_dump(property_exists('A','private_var'));        //true

var_dump(property_exists('A','static_public_var'));    //true
var_dump(property_exists('A','static_protected_var')); //true
var_dump(property_exists('A','static_private_var'));   //true

var_dump(property_exists('A','public_func'));          //false
var_dump(property_exists('A','static_public_func'));   //false

var_dump(property_exists(new A(),'public_var'));         //true
var_dump(property_exists(new A(),'protected_var'));      //true
var_dump(property_exists(new A(),'private_var'));        //true

(new A())->public_func();  //true
A::static_public_func();   //true

echo "-----\n";
var_dump(method_exists('A', 'public_func'));
var_dump(method_exists('A', 'private_func'));
