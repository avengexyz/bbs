<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';
//引入分页操作文件
include_once 'inc/page.inc.php';

session_start();
$link=connect();

// var_dump($_SESSION['member_id']);exit();

if(!isset($_SESSION['name'])){
    echo "未登录,请登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}

if(!is_numeric($_SESSION['member_id'])){
    echo "会员id参数不合法!请注销重新登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}

//验证数据库里有没有这个用户
$query="select * from sfk_member where id={$_SESSION['member_id']}";
$result_memebr=execute($link, $query);
if(mysqli_num_rows($result_memebr)!=1){
    echo "你所访问的会员不存在!请注销重新登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}

//查询帖子总数
$query="select count(*) from sfk_content where member_id={$_SESSION['member_id']}";
$count_all=num($link, $query);

//查询用户信息 用户名 头像图片
$query="select name,photo from sfk_member where id={$_SESSION['member_id']}";
$result_memebr1=execute($link, $query);
$data_member=mysqli_fetch_assoc($result_memebr1);

//分页
$page=page($count_all,5);

//查询所属用户的所有帖子
$query="select *from sfk_content where member_id={$_SESSION['member_id']}  {$page['limit']}";
$result_content=execute($link, $query);

//引入头部模板
include_once 'index/inc/header.html';
//引入主体模板
include_once 'index/inc/member.html';
//引入尾部模板
include_once 'index/inc/footer.html'; 