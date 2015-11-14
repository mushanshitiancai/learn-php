<?php 

error_reporting(E_ALL);

class ParentClass{}
class Child extends ParentClass{}

$parentObj = new ParentClass();
$childObj = new Child();

var_dump(is_a($childObj,'Child'));        //true
var_dump(is_a($childObj,'ParentClass'));  //true

var_dump(is_a($parentObj,'Child'));        //false
var_dump(is_a($parentObj,'ParentClass'));  //true

var_dump(is_a('Child','Child'));        //false
var_dump(is_a('Child','ParentClass'));  //false

var_dump(is_a('Child','Child',true));        //true
var_dump(is_a('Child','ParentClass',true));  //true