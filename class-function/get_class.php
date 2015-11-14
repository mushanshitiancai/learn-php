<?php 

error_reporting(E_ALL);

require '../common/MyClass.php';

$obj = new MyClass();

var_dump(get_class($obj));

var_dump(get_class());
var_dump($obj->get_class());

// var_dump(get_class("MyClass"));
