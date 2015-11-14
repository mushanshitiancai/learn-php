<?php 

error_reporting(E_ALL);

class A{
	public $public_var;
	private $private_var;
	protected $protected_var;

	function __construct(){
		echo "A::__construct\n";
	}

	function setUp(){
		$this->public_var = 1;
		$this->private_var = 2;
		$this->protected_var = 3;
		$this->extra = true;
	}

	function get_object_vars(){
		return get_object_vars($this);
	}
}

$obj = new A();
var_dump(get_object_vars($obj));
var_dump($obj->get_object_vars());

$obj->setUp();
$obj->extraOut = true;
var_dump(get_object_vars($obj));
var_dump($obj->get_object_vars());
