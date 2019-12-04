<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';

if(isset($_POST['submit'])){
    include_once 'inc/check_login.inc.php';
    $link=connect();
    $query="select * from sfk_member where name='{$_POST['name']}' and pw=md5('{$_POST['pw']}') ";
    // echo $query;
    $result=execute($link,$query);
    if(mysqli_num_rows($result)==1){
        setcookie('sfk[name]',$_POST['name'],time()+$_POST['time']);
        setcookie('sfk[pw]',md5($_POST['pw']),time()+$_POST['time']);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        foreach($row as $v){
            $name= $v['name'];
            $member_id = $v['id'];
        }
        $_SESSION['name']=$name;
        $_SESSION['member_id']=$member_id;
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
   //引入头部模板
    include_once 'index/inc/header.html';
    //引入主体模板
    include_once 'index/inc/login.html';
    //引入尾部模板
    include_once 'index/inc/footer.html'; 
}
