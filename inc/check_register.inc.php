<?php
//引入登录验证文件
include_once 'islogin.inc.php';

//测试cookie
// var_dump(is_login()); 
// var_dump($_COOKIE['sfk']['name']);
// var_dump($_COOKIE['sfk']['pw']);
// exit;

if(is_login()){
    echo "你已经登录,请不要重复注册";
    // 3秒后跳转到父板块
    header("refresh:3;url=../register.php");
    exit(); 
}

if(empty($_POST['name'])){
    echo "用户名不得为空";
    // 3秒后跳转到父板块
    header("refresh:3;url=../register.php");
    exit();
}
//mb_strlen()获取字符串的长度
if(mb_strlen($_POST['name'])>32){
    echo "用户名不得超过32位";
    // 3秒后跳转到父板块
    header("refresh:3;url=../register.php");
    exit();
}
if(mb_strlen($_POST['pw'])<6){
    echo "密码不得小于6位";
    // 3秒后跳转到父板块
    header("refresh:3;url=../register.php");
    exit();
}

if($_POST['pw'] != $_POST['confirm_pw']){
    echo "两次输入密码不相同";
    // 3秒后跳转到父板块
    header("refresh:3;url=../register.php");
    exit();
}
//1.初始化session 不管是保存还是获取删除等等都要先初始化
session_start();
if(strtolower($_POST['vcode'])!=strtolower($_SESSION['captcha'])){
    echo "验证码错误";
    // 3秒后跳转到父板块
    header("refresh:3;url=../register.php");
    exit();
}



?>