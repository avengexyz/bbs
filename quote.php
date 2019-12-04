<?php
//这个是解决乱码问题
header("Content-type:text/html;charset=utf-8");

//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';

session_start();

if(isset($_SESSION['name'])){
    if(isset($_POST['submit'])){
        include 'inc/check_quote.inc.php';
        $link=connect();
        $_POST=escape($link,$_POST);
        // $query="insert into sfk_reply(content_id,content,time,member_id) values({$_GET['id']},{$_POST['content']},now(),{$_SESSION['member_id']})";
        $query="insert into sfk_reply(content_id,quote_id,content,time,member_id) values({$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$_SESSION['member_id']})";
        // echo $query;exit;
        execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            echo "发布成功";
            // 3秒后跳转到父板块
            header("refresh:3;url=./show.php?id={$_GET['id']}");
            exit();
        }else{
            echo "发布失败";
            // 3秒后跳转到父板块
            header("refresh:3;url=./show.php?id={$_GET['id']}");
            exit();
        }

    }else{
        if(empty($_GET['id']) || !is_numeric($_GET['id'])){
            echo "帖子id不合法！";
            // 3秒后跳转到父板块
            header("refresh:3;url=../index.php");
            exit();
        }
        
        $query="select * from sfk_reply where id={$_GET['reply_id']}";
        $link=connect();
        $result=execute($link, $query);
        if(mysqli_num_rows($result)!=1){
            echo "帖子不存在！";
            // 3秒后跳转到父板块
            header("refresh:3;url=../show.php?id={$_GET['id']}");
            exit();
        }

        $link=connect();
        $query="select sfk_member.name,sfk_reply.content from sfk_reply,sfk_member where sfk_reply.id={$_GET['reply_id']} and sfk_reply.member_id=sfk_member.id";
        $result=execute($link, $query);
        $data=mysqli_fetch_assoc($result);
        //引入头部模板
        include_once 'index/inc/header.html';
        //引入主体模板
        include_once 'index/inc/quote.html';
        //引入尾部模板
        include_once 'index/inc/footer.html';  
    }
}else{
    echo "未登录,请登陆后在回复";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
}