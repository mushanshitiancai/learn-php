<?php 

// var_dump(iconv_get_encoding());
// iconv_set_encoding('input_encoding', 'utf-8');
// iconv_set_encoding('output_encoding', 'utf-8');
iconv_set_encoding('internal_encoding', 'utf-8');

var_dump(strlen('你好'));
var_dump(iconv_strlen('你好'));  // 设置internal_encoding为utf-8时，才是正确的
                                 // 因为int iconv_strlen ( string $str [, string $charset = ini_get("iconv.internal_encoding") ] )