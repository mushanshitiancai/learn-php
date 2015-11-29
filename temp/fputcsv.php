<?php 

$f = fopen('temp.txt','w');

$a = array(1,2,3);
$b = array(
	'a'=>'a',
	'b'=>'b'
);

fputcsv($f,$a);
fputcsv($f,$b);
fclose($f);