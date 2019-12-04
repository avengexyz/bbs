<?php
//这个是解决乱码问题
header("Content-type:text/html;charset=utf-8");

if (!session_id()) session_start();

if(!isset($_SESSION['manage'])){
    echo "没有登录，不需要注销";
    // 3秒后跳转到父板块
    header("refresh:3;url=../index.php");
    exit();
}

session_destroy();


echo "注销成功";
// 3秒后跳转到父板块
header("refresh:3;url=./login.php");