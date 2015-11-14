<?php 

error_reporting(E_ALL);

class ParentClass{}
class Child extends ParentClass{}

var_dump(get_parent_class('ParentClass'));
var_dump(get_parent_class('Child'));