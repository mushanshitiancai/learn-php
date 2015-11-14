<?php 

class MyClass{

	public $public_var;
	private $private_var;
	protected $protected_var;

	function __construct(){
		echo "MyClass::__construct\n";
	}

	function public_func(){

	}

	private function private_func(){

	}

	protected function protected_function(){

	}

	function get_class_methods(){
		return get_class_methods('MyClass');
	}

	static function get_class_methods_static(){
		return get_class_methods('MyClass');
	}

	function get_class_vars(){
		return get_class_vars('MyClass');
	}

	function get_class(){
		return get_class();
	}
}
