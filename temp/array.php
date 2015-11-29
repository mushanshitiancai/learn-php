<?php


/**
 * PHP数组不会按key排序！而是按照插入顺序排序！
 */
/*
$a = array();
$a[1] = 1;
$a[5] = 5;
$a[3] = 3;

var_dump($a);
// array(3) {
//   [1]=>
//   int(1)
//   [5]=>
//   int(5)
//   [3]=>
//   int(3)
// }

foreach($a as $k=>$v){
	echo "$k=>$v\n";
}
// 1=>1
// 5=>5
// 3=>3
*/


/**
 * 一个案例
 */
/*
$headers = array('one','two');
$data = array(
	array('one'=>11,'two'=>12),
	array('one'=>11,'two'=>12)
);

foreach($data as &$line){
	// $line['three'] = 3;
}
// var_dump($line);
unset($line);

foreach($data as $line){
	foreach ($line as $key => $field) {
		foreach ($headers as $i => $header) {
			if($header === $key){
				echo "$header == $key\n";
				$line[$i] = $field;
				unset($line[$key]);
				break;
			}
		}
	}
}
var_dump($data);
*/

/**
 * 
 */
$a = array(1,2,'a'=>'a');
var_dump(count($a));

for ($i=0; $i < count($a); $i++) { 
	var_dump($a[$i]);
}

while(list($k,$v) = each($a)){
	var_dump($v);
}










