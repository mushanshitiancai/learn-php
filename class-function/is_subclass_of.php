<?php 

error_reporting(E_ALL);

class ParentClass{}
class Child extends ParentClass{}

$childObj = new Child();

var_dump(is_subclass_of($childObj,'Child'));        //false
var_dump(is_subclass_of($childObj,'ParentClass'));  //true
var_dump(is_subclass_of('Child','ParentClass'));    //true

var_dump(is_subclass_of($childObj,'Child',false));        //false
var_dump(is_subclass_of($childObj,'ParentClass',false));  //true
var_dump(is_subclass_of('Child','ParentClass',false));    //false