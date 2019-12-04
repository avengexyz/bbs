<?php
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASSWORD','root');
define('DB_DATABASE','sfkbbs');
define('DB_PORT','3306');
//我们的项目（程序），在服务器上的绝对路径
//define创建常量 常量名 值
//dirname() 函数返回路径中的目录名称部分。
define('SA_PATH',dirname(dirname(__FILE__)));
//我们的项目在web根目录下面的位置（哪个目录里面）
//define创建常量 常量名 值
//str_replace() 函数替换字符串中的一些字符（区分大小写）。
//str_replace(find,replace,string,count) 
//find必需。规定要查找的值。
//replace必需。规定替换 find 中的值的值。 
//string必需。规定被搜索的字符串。
//count可选。一个变量，对替换数进行计数。
define('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',SA_PATH)).'/');
?>