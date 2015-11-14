<?php 

error_reporting(E_ALL);

require '../common/MyClass.php';

$obj = new MyClass();
// var_dump(get_class_vars($obj));
var_dump(get_class_vars('MyClass'));
var_dump($obj->get_class_vars());