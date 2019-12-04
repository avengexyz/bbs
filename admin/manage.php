<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

//查询出会员数据
$link=connect();
$query="select * from sfk_manage";
$result=execute($link,$query);

//引入html模板头部
include_once 'inc/header.html';
//引入html模板左边
include_once 'inc/left.html';
//引入html模板主体
include_once 'inc/manage.html';
//引入html模板底部
include_once 'inc/footer.html';