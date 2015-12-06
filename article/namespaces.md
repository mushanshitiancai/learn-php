# PHP命名空间
## 专业术语
1. 非限定名称 Unqualified name
    名称中不包含命名空间分隔符的标识符，例如 Foo

2.限定名称 Qualified name
    名称中含有命名空间分隔符的标识符，例如 Foo\Bar

3.完全限定名称 Fully qualified name
    名称中包含命名空间分隔符，并以命名空间分隔符开始的标识符，例如 \Foo\Bar。 namespace\Foo 也是一个完全限定名称。

## 定义命名空间
虽然所有的PHP代码都可以放到命名空间下，但是只有

- 类（包括abstracts类和traits）
- 接口
- 函数
- 常量

这四个类型受到命名空间的作用。

定义命名空间使用`namespaces`关键字，命名空间需要定义在文件的所有代码之前（declare语句除外）。需要注意的是，非PHP代码也不能出现在namespaces声明之前：

```
<html>
<?php
namespace MyProject; // fatal error - namespace must be the first statement in the script
?>
```

同一个命名空间可以重复定义，也就是，一个命名空间里的内容可以出现在多个文件中。

## 一个文件中定义多个命名空间

```
<?php
namespace MyProject {

const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
}

namespace AnotherProject {

const CONNECT_OK = 1;
class Connection { /* ... */ }
function connect() { /* ... */  }
}

namespace { // global code
session_start();
$a = MyProject\connect();
echo MyProject\Connection::start();
}
?>
```

不用花括号也可以，不过用花括号好。

如果代码中还有全局命名空间的代码，就必须用`namespace {...}`

## 命名空间的解析
命名空间的解析和文件路径的解析是一个道理的。

## namespace关键字和__NAMESPACE__常量
PHP支持两种抽象的访问当前命名空间内部元素的方法，`__NAMESPACE__`魔术常量和`namespace`关键字。

## 使用命名空间：别名/导入
类似于在类 unix 文件系统中可以创建对其它的文件或目录的符号连接。

```
<?php
namespace foo;
use My\Full\Classname as Another;

// 下面的例子与 use My\Full\NSname as NSname 相同
use My\Full\NSname;

// 导入一个全局类
use ArrayObject;

// importing a function (PHP 5.6+)
use function My\Full\functionName;

// aliasing a function (PHP 5.6+)
use function My\Full\functionName as func;

// importing a constant (PHP 5.6+)
use const My\Full\CONSTANT;

$obj = new namespace\Another; // 实例化 foo\Another 对象
$obj = new Another; // 实例化 My\Full\Classname　对象
NSname\subns\func(); // 调用函数 My\Full\NSname\subns\func
$a = new ArrayObject(array(1)); // 实例化 ArrayObject 对象
// 如果不使用 "use \ArrayObject" ，则实例化一个 foo\ArrayObject 对象
func(); // calls function My\Full\functionName
echo CONSTANT; // echoes the value of My\Full\CONSTANT
?>
```

通过use操作符导入/使用别名，一行中包含多个use语句

```
<?php
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // 实例化 My\Full\Classname 对象
NSname\subns\func(); // 调用函数 My\Full\NSname\subns\func
?>
```

导入操作只能导入命名空间或者是类，不能是函数或者变量。

导入操作是在编译执行的，但动态的类名称、函数名称或常量名称则不是。

```
<?php
use My\Full\Classname as Another, My\Full\NSname;

$obj = new Another; // 实例化一个 My\Full\Classname 对象
$a = 'Another';
$obj = new $a;      // 实际化一个 Another 对象
?>
```

所以动态调用、实例化，一定要使用`完全限定名称`

## 使用命名空间：后备全局函数/常量
对于函数和常量来说，如果当前命名空间中不存在该函数或常量，PHP 会退而使用全局空间中的函数或常量

## 名称解析规则
注意一点：

```
> 在命名空间内部（例如A\B），对非限定名称的函数调用是在运行时解析的。例如对函数 foo() 的调用是这样解析的：
在当前命名空间中查找名为 A\B\foo() 的函数
尝试查找并调用 全局(global) 空间中的函数 foo()。

> 在命名空间（例如A\B）内部对非限定名称或限定名称类（非完全限定名称）的调用是在运行时解析的。下面是调用 new C() 及 new D\E() 的解析过程： new C()的解析:
在当前命名空间中查找A\B\C类。
尝试自动装载类A\B\C。
```

在命名空间中，找不到命名空间下的类，不会去全局空间中搜索！！

所以再命名空间中使用全局类，需要`\stdClass`

## 参考文章
- [PHP: Namespaces - Manual](http://php.net/manual/en/language.namespaces.php)
- [PHP: FAQ: things you need to know about namespaces - Manual](http://php.net/manual/zh/language.namespaces.faq.php#language.namespaces.faq.globalclass)