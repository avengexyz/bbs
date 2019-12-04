<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';

session_start();
$link=connect();

if(!isset($_SESSION['name'])){
    echo "未登录,请登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}

if(!is_numeric($_SESSION['member_id'])){
    echo "会员id参数不合法!请注销重新登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "帖子id参数不合法!";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}

$query="select member_id from sfk_content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
    if($data_content['member_id']=$_SESSION['member_id']){
        $query="delete from sfk_content where id={$_GET['id']}";
        execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            echo "删除成功";
            // 3秒后跳转到父板块
            header("refresh:3;url=member.php");
            exit();
		}else{
            echo "删除失败";
            // 3秒后跳转到父板块
            header("refresh:3;url=member.php");
            exit();
		}
    }else{
        echo "这个帖子不属于你，你没有权限删除!";
        // 3秒后跳转到父板块
        header("refresh:3;url=member.php");
        exit();
    }
}else{
    echo "帖子不存在";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}