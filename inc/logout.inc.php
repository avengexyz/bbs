<?php
//这个是解决乱码问题
header("Content-type:text/html;charset=utf-8");

if (!session_id()) session_start();

if(!isset($_SESSION['name'])){
    echo "没有登录，不需要注销";
    // 3秒后跳转到父板块
    header("refresh:3;url=../index.php");
    exit();
}

session_destroy();

setcookie("sfk[name]",null,-86400,'/');
setcookie("sfk[pw]",null,-86400,'/');

echo "注销成功";
// 3秒后跳转到父板块
header("refresh:3;url=../index.php");