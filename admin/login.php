<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

if(isset($_POST['submit'])){
    include_once 'check_login.inc.php';
    $link=connect();
    $query="select * from sfk_manage where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}') ";
    // echo $query;
    $result=execute($link,$query);
    if(mysqli_num_rows($result)==1){
        $data = mysqli_fetch_assoc($result);
        
        $_SESSION['manage']['name']=$data['name'];
        $_SESSION['manage']['pw']=$data['pw'];
        $_SESSION['manage']['id']=$data['id'];
        $_SESSION['manage']['level']=$data['level'];

        echo "登录成功";
        // 3秒后跳转到父板块
        header("refresh:3;url=./index.php");
        exit();
    }else{
        echo "登录失败，账号或者密码错误";
        // 3秒后跳转到父板块
        header("refresh:3;url=./login.php");
        exit();
    }
}else{
    //引入html模板主体
    include_once 'inc/login.html';
}

