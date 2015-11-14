<?php 

error_reporting(E_ALL);

require '../common/MyClass.php';

$obj = new MyClass();
var_dump(get_class_methods($obj));
//or
var_dump(get_class_methods("MyClass"));

var_dump($obj->get_class_methods());
var_dump(MyClass::get_class_methods_static());