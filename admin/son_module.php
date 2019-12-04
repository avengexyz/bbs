<?php
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

//查询子板块数据
$link=connect();
$query="select * from sfk_son_module";
$result=execute($link,$query);
$row=mysqli_fetch_all($result,MYSQLI_ASSOC);


//引入html模板头部
include_once 'inc/header.html';
//引入html模板左边
include_once 'inc/left.html';
//引入html模板主体
include_once 'inc/son_module.html';
//引入html模板底部
include_once 'inc/footer.html';

?>