<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';

session_start();

if(isset($_SESSION['name'])){
    if(isset($_POST['submit'])){
        include 'inc/check_publish.inc.php';
        $_POST=escape($link,$_POST);
        $query="insert into sfk_content(module_id,title,content,time,member_id) values({$_POST['module_id']},'{$_POST['title']}','{$_POST['content']}',now(),{$_SESSION['member_id']})";
        execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            echo "发布成功";
            // 3秒后跳转到父板块
            header("refresh:3;url=./publish.php");
            exit();
        }else{
            echo "发布失败";
            // 3秒后跳转到父板块
            header("refresh:3;url=./publish.php");
            exit();
        }
    }else{
        $link=connect();
        $query="select * from sfk_father_module order by sort desc";
        $result_father=execute($link, $query);
        
      
    
        //引入头部模板
        include_once 'index/inc/header.html';
        //引入主体模板
        include_once 'index/inc/publish.html';
        //引入尾部模板
        include_once 'index/inc/footer.html';  
    }
}else{
    echo "未登录,请登陆后在发帖";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
}


