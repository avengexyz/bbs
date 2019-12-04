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
        include 'inc/check_reply.inc.php';
        // var_dump($_POST);var_dump($_GET);exit;
        $link=connect();
        $_POST=escape($link,$_POST);
        $query="insert into sfk_reply(content_id,content,time,member_id) values({$_GET['id']},{$_POST['content']},now(),{$_SESSION['member_id']})";
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
        
        $query="select * from sfk_content where id={$_GET['id']}";
        $link=connect();
        $result=execute($link, $query);
        if(mysqli_num_rows($result)!=1){
            echo "帖子不存在！";
            // 3秒后跳转到父板块
            header("refresh:3;url=../reply.php?id={$_GET['id']}");
            exit();
        }

        $link=connect();
        //查询 父板块名称 id 子板块名称 id 帖子名 谁发布的帖子 发布的内容
        // $query="select * from sfk_father_module order by sort desc";
        $query="
        SELECT
        sfk_father_module.id father_id,
        sfk_father_module.module_name father_name,
        sfk_son_module.id son_id,
        sfk_son_module.module_name son_name,
        sfk_content.title,
        sfk_content.id,
        sfk_reply.member_id,
        sfk_content.content,
        sfk_member.`name`
        FROM
        sfk_reply,sfk_content,sfk_father_module,sfk_son_module,sfk_member
        WHERE
        sfk_content.id={$_GET['id']}
        AND
        sfk_content.module_id=sfk_son_module.id
        AND
        sfk_son_module.father_module_id=sfk_father_module.id
        AND
        sfk_content.member_id=sfk_reply.member_id
        AND
        sfk_reply.member_id=sfk_member.id
        ";
        $result=execute($link, $query);
        $data=mysqli_fetch_assoc($result);
        // var_dump($data);
      
    
        //引入头部模板
        include_once 'index/inc/header.html';
        //引入主体模板
        include_once 'index/inc/reply.html';
        //引入尾部模板
        include_once 'index/inc/footer.html';  
    }
}else{
    echo "未登录,请登陆后在回复";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
}


