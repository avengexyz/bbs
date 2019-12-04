<?php

//1.初始化session 不管是保存还是获取删除等等都要先初始化
session_start();
if(strtolower($_POST['vcode'])!=strtolower($_SESSION['captcha'])){
    echo "验证码错误";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}

if(empty($_POST['name'])){
    echo "用户名不得为空";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}

if(mb_strlen($_POST['name'])>32){
    echo "用户名不得超过32位";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}
 
if(mb_strlen($_POST['pw'])<6){
    echo "密码不得小于6位";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}

if(empty($_POST['pw'])){
    echo "密码不得为空";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit();
}