# PHP类相关函数
虽然PHP不是一开始就是面向对象的语言，而且基因上也不是面向对象友好的但是，随着PHP版本的发展，PHP的面向对象特性还是渐渐的向Java靠拢了。自从PHP有了面向对象特性后，基本所有的框架，库，网站都是使用了面向对象来写的。所以了解PHP的类还是很重要的。

PHP提供了很多函数来操作类，这也是面向对象不干净的地方。。。但是这些函数的确可以很方便的操作类。

![php-class-function](http://img.blog.csdn.net/20151114214930665)

## __autoload - 自动加载未定义的类
这个函数不是供我们调用，而是需要我们实现的一个函数。如果PHP找不到一个类的定义，就会调用`__autoload`函数，并把类名作为字符串参数传入。

这个函数也体现了PHP怎么方便怎么简单怎么来的设计思想。。。在Java中，你用一个类就得乖乖import没啥取巧的。

没有定义类直接实例化：

    $obj = new MyClass();

报错：

    Fatal error: Class 'MyClass' not found in /Users/mazhibin/project/learn/learn-php/class-function/__autoload.php on line 7

可以定义`__autoload`函数：

```
function __autoload($class){
    if($class == 'MyClass'){
        require("../common/MyClass.php");
    }
}
```

这样就可以找到`MyClass`这个类了。

### 关于__autoload的问题
1. 多次`new MyClass()`会多次调用`__autoload`么？
  
    不会。第一次调用`__autoload`后，`MyClass`已被加载，所以就不需要再调用`__autoload`了。

2. 可以存在多个`__autoload`函数么？

    不能。而且如果定义多个`__autoload`函数会报错：

    ````
    Fatal error: Cannot redeclare __autoload() (previously declared in /Users/mazhibin/project/learn/learn-php/class-function/__autoload.php:3) in /Users/mazhibin/project/learn/learn-php/class-function/__autoload.php on line 13
    ````

因为`__autoload`函数只能定义一个，所以一般使用的是`spl_autoload_register()`。

## class_alias - 定义类别名

这个函数就和shell中的alias一样，shell的alias命令定义命令的别名，PHP中的class_alias定义的是类的别名。

    bool class_alias ( string $original , string $alias [, bool $autoload = TRUE ] )

使用一个类的别名：

```
class_alias('MyClass','My');

$my = new My();
$myclass = new MyClass();

var_dump($my == $myclass);              //true
var_dump($my === $myclass);             //false
var_dump($my instanceof $myclass);      //true

var_dump($my instanceof My);            //true
var_dump($my instanceof MyClass);       //true

var_dump($myclass instanceof My);       //true
var_dump($myclass instanceof MyClass);  //true
```

定义了别名，两个类还是一个类，记住这个就行了。

如果原本的类无法加载，则会报错：

```
Warning: Class 'MyClass' not found in /Users/mazhibin/project/learn/learn-php/class-function/class_alias.php on line 3

Fatal error: Class 'My' not found in /Users/mazhibin/project/learn/learn-php/class-function/class_alias.php on line 5
```

这个时候，有两个解决方法。一个是直接include/require，一个是autoload。如果使用autoload，第三个参数就起作用了。

### class_alias的autoload参数的效果

默认，`$autoload`参数为`true`，如果原本的类不存在，就会使用自动加载。如果`$autoload`参数设置为`false`，则如果原本的类不存在，就去找别名字符串指定的类。见例子：

```
function __autoload($class){
    echo "__autoload $class\n";

    if($class == 'MyClass'){
        require("../common/MyClass.php");
    }else if($class == 'My'){
        require("../common/My.php");
    }
}

class_alias('MyClass','My',false);

$my = new My();
$myclass = new MyClass();

var_dump($my == $myclass);              
var_dump($my === $myclass);             
var_dump($my instanceof $myclass);      

var_dump($my instanceof My);            
var_dump($my instanceof MyClass);       

var_dump($myclass instanceof My);       
var_dump($myclass instanceof MyClass);  
```

输出：

```
Warning: Class 'MyClass' not found in /Users/mazhibin/project/learn/learn-php/class-function/class_alias2.php on line 13
__autoload My
My::__construct
__autoload MyClass
MyClass::__construct
bool(false)
bool(false)
bool(false)
bool(true)
bool(false)
bool(false)
bool(true)
```

可以看到，虽然定义了My为MyClass的别名，因为`$autoload=false`，所以在找不到My类时，不会自动加载"MyClass"指定的类，而是尝试加载"My"类。所以此时别名效果就失效了。不过PHP会先爆出Warning。

### 可以定义和别名同名的类么？

```
function __autoload($class){
    echo "__autoload $class\n";

    if($class == 'MyClass'){
        require("../common/MyClass.php");
    }else if($class == 'My'){
        require("../common/My.php");
    }
}

class My{
    function __construct(){
        echo "this My::__construct\n";
    }
}

class_alias('MyClass','My',true);

$my = new My();
```

`$autoload=true`时，`new My()`先尝试读取MyClass，这时发现，代码中已经定义了My类（此时两者已经等价了，所以认为是重定义），和普通重定义不一样（普通重定义报Fatal），这次报的是Warning，并且使用的是My这个定义而不是MyClass这个定义。

```
__autoload MyClass

Warning: Cannot redeclare class My in /Users/mazhibin/project/learn/learn-php/class-function/class_alias3.php on line 22
this My::__construct
```

`$autoload=true`时，PHP先报MyClass找不到的Warning，然后淡定地使用本文件定义的My类。

```
Warning: Class 'MyClass' not found in /Users/mazhibin/project/learn/learn-php/class-function/class_alias3.php on line 20
this My::__construct
```

## class_exists/interface_exists/trait_​exists - 判断一个类/接口/traits是否定义

    bool class_exists ( string $class_name [, bool $autoload = true ] )
    bool interface_exists ( string $interface_name [, bool $autoload = true ] )
    bool trait_exists ( string $traitname [, bool $autoload ] )

需要注意的就是
1. xxx_name大小写不敏感
2. autoload指定是否在找不到时使用autoloader

## get_class_methods - 获取类的方法名组成的数组

    array get_class_methods ( mixed $class_name )

类定义如下：

```
class MyClass{
    function __construct(){}
    function public_func(){}
    private function private_func(){}
    protected function protected_function(){}
}
```

获取类的所有方法：

```
$obj = new MyClass();
var_dump(get_class_methods($obj));
//or
var_dump(get_class_methods("MyClass"));
```

输出：

```
array(2) {
  [0]=>
  string(11) "__construct"
  [1]=>
  string(11) "public_func"
}
```

可以看出，`get_class_methods`可以获得构造函数，但是无法获得无法访问的函数。

所以如果在类的成员函数中调用`get_class_methods`可以获得所有方法。

## get_class_vars - 获得类的默认属性组成的键值数组

    array get_class_vars ( string $class_name )

**注意两点：**

1. class_name只能是string，如果你手上只有类的实例，可以使用`get_class`函数
2. 该函数只能获得当前作用域可以访问的属性，所以类外部调用只能获得public属性，类内部调用可以获得所有属性。

## get_class - 返回对象的类名

    string get_class ([ object $obj ] )

这个函数很直接了当了，不过还是需要注意：

`obj`参数可以不传，这时返回调用这个函数的类的名字，如果在一个函数外调用无参数的get_class，则会报Warning：
    
```
Warning: get_class() called without object from outside a class in /Users/mazhibin/project/learn/learn-php/class-function/get_class.php on line 11
```

并且返回`flase`。

## get_declared_classes/get_declared_interfaces/get_declared_traits

    array get_declared_classes ( void )
    array get_declared_interfaces ( void )
    array get_declared_traits ( void )

返回调用`get_declared_xxx`时，作用域中可以使用的类/接口/traits。

## get_object_vars — 返回由对象属性组成的关联数组

    array get_object_vars ( object $obj )

`get_object_vars`获得对象在目前作用域可以获取的属性的关联数组。

```
class A{
    public $public_var;
    private $private_var;
    protected $protected_var;

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
```

输出：

```
array(1) {
  ["public_var"]=>
  NULL
}
array(3) {
  ["public_var"]=>
  NULL
  ["private_var"]=>
  NULL
  ["protected_var"]=>
  NULL
}
array(3) {
  ["public_var"]=>
  int(1)
  ["extra"]=>
  bool(true)
  ["extraOut"]=>
  bool(true)
}
array(5) {
  ["public_var"]=>
  int(1)
  ["private_var"]=>
  int(2)
  ["protected_var"]=>
  int(3)
  ["extra"]=>
  bool(true)
  ["extraOut"]=>
  bool(true)
}
```

总结：
1. 类外部只能获得public的属性，类内部可以获得所有属性。
2. PHP类的属性是可以随时扩展的，类的内部和外部都可以对属性进行扩展。`get_object_vars`可以获得当前这个对象的所有属性，包括运行时添加的属性。

## get_parent_class — 返回对象或类的父类名

    string get_parent_class ([ mixed $obj ] )

```
class ParentClass{}
class Child extends ParentClass{}

var_dump(get_parent_class('ParentClass'));
var_dump(get_parent_class('Child'));
```

输出：

```
bool(false)
string(11) "ParentClass"
```

如果参数对应的类没有父类，则返回false。


参考前面的`class_exists`。

## is_a — 判断是否是类/子类的实例

    bool is_a ( object $object , string $class_name [, bool $allow_string = FALSE ] )

`$allow_string`函数指定`$object `是否可以是字符串。如果指定为false，则在传入字符串时，总返回false。

```
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
```

需要注意的就是，`is_a`传入子类对象和父类时，返回true。

## is_subclass_of — 如果此对象是该类的子类，则返回 TRUE

    bool is_subclass_of ( mixed $object , string $class_name [, bool $allow_string = TRUE ] )

和`is_a`不同，`is_subclass_of`只会是在子类的时候返回true。

`$allow_string`函数指定`$object `是否可以是字符串。如果指定为false，则在传入字符串时，总返回false。

```
class ParentClass{}
class Child extends ParentClass{}

$childObj = new Child();

var_dump(is_subclass_of($childObj,'Child'));        //false
var_dump(is_subclass_of($childObj,'ParentClass'));  //true
var_dump(is_subclass_of('Child','ParentClass'));    //true

var_dump(is_subclass_of($childObj,'Child',false));        //false
var_dump(is_subclass_of($childObj,'ParentClass',false));  //true
var_dump(is_subclass_of('Child','ParentClass',false));    //false
```

## method_exists — 判断方法是否存在

    bool method_exists ( mixed $object , string $method_name )

**注意：**`method_exists`不会考虑属性的访问修饰符（`public/protected/private`）。

## property_exists - 判断类属性是否存在

    bool property_exists ( mixed $class , string $property )

判断类中是否存在字符串`$property`指定的属性。

**注意：**`property_exists`不会考虑属性的访问修饰符（`public/protected/private`）。

```
<?php
class A{
    public $public_var;
    protected $protected_var;
    private $private_var;

    static public $static_public_var;
    static protected $static_protected_var;
    static private $static_private_var;

    public function public_fuck(){
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

var_dump(property_exists('A','public_fuck'));          //false
var_dump(property_exists('A','static_public_func'));   //false

var_dump(property_exists(new A(),'public_var'));         //true
var_dump(property_exists(new A(),'protected_var'));      //true
var_dump(property_exists(new A(),'private_var'));        //true

(new A())->public_fuck();  //true
A::static_public_func();   //true
```

## get_called_class — 获得后期静态绑定（"Late Static Binding"）类的名称

    string get_called_class ( void )

```
class A{
    static function func(){
        var_dump(get_called_class());
    }
}

class B extends A{}

A::func();
B::func();
var_dump(get_called_class());
```

输出：

```
string(1) "A"
string(1) "B"

Warning: get_called_class() called from outside a class in /Users/mazhibin/project/learn/learn-php/class-function/get_called_class.php on line 15
bool(false)
```

## 对应版本

![php-class-function-version](http://img.blog.csdn.net/20151114215053043)

## 参考文章
[PHP: Classes/Object Functions - Manual](http://php.net/manual/en/ref.classobj.php)