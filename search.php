<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';
//引入分页操作文件
include_once 'inc/page.inc.php';

$link=connect();
if(!isset($_GET['keyword'])){
	$_GET['keyword']='';
}
//trim() 方法用于删除字符串的头尾空白符。
$_GET['keyword']=trim($_GET['keyword']);
//对搜索内容进行转义
$_GET['keyword']=escape($link,$_GET['keyword']);
//搜索总记录数
$query="select count(*) from sfk_content where title like '%{$_GET['keyword']}%'";
$count_all=num($link,$query);

//调用分页
$page=page($count_all,20);

//搜索内容
$query="select * from sfk_content where title like '%{$_GET['keyword']}%' {$page['limit']} ";
$result_content=execute($link,$query);

//引入头部模板
include_once 'index/inc/header.html';
//引入主体模板
include_once 'index/inc/search.html';
//引入尾部模板
include_once 'index/inc/footer.html'; 