<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

$link=connect();


if (!session_id()) session_start();

if(!isset($_SESSION['manage']['id'])){
	echo ('未登录');
	//3秒后跳转到父板块
	header("refresh:3;url=login.php");
}

//查询父板块信息
$query="select * from sfk_manage where id={$_SESSION['manage']['id']}";
$result_manage=execute($link, $query);
$data_manage=mysqli_fetch_assoc($result_manage);

if($data_manage['level']=='0'){
	$data_manage['level']='超级管理员';
}else{
	$data_manage['level']='普通管理员';
}

//查询父板块总数
$query="select count(*) from sfk_father_module";
$count_father_module=num($link,$query);

//查询子板块总数
$query="select count(*) from sfk_son_module";
$count_son_module=num($link,$query);

//查询帖子总数
$query="select count(*) from sfk_content";
$count_content=num($link,$query);

//查询回复总数
$query="select count(*) from sfk_reply";
$count_reply=num($link,$query);

//查询会员总数
$query="select count(*) from sfk_member";
$count_member=num($link,$query);

//查询管理员总数
$query="select count(*) from sfk_manage";
$count_manage=num($link,$query);



//引入html模板头部
include_once 'inc/header.html';
//引入html模板左边
include_once 'inc/left.html';
//引入html模板主体
include_once 'inc/index.html';
//引入html模板底部
include_once 'inc/footer.html';
