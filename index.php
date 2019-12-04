<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';

$link=connect();
$query="select * from sfk_father_module order by sort desc";
$result_father=execute($link, $query);

//引入头部模板
include_once 'index/inc/header.html';
//引入主体模板
include_once 'index/inc/index.html';
//引入尾部模板
include_once 'index/inc/footer.html';

?>