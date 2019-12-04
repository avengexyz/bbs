<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

if (!session_id()) session_start();
if($_SESSION['manage']['level']>0){
    // 跳转回原网页如果没有原网页跳转回主页
    if($_SERVER['HTTP_REFERER']){
        $url=$_SERVER['HTTP_REFERER'];
    }else{
        $url='index.php';
    }
    echo "权限不足";
    header("refresh:3;url=$url");
    exit();
}

if(isset($_POST['submit'])){
    include_once '../inc/check_manage.inc.php';
    //转义一下数据
    $_POST=escape($link,$_POST);
    $link=connect();
    $query="insert into sfk_manage(name,pw,create_time,level) values('{$_POST['name']}',md5({$_POST['pw']}),now(),{$_POST['level']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        echo "添加成功！";
        // 3秒后跳转到父板块
        header("refresh:3;url=../admin/manage_add.php");
        exit();
    }else{
        echo "添加失败！";
        // 3秒后跳转到父板块
        header("refresh:3;url=../admin/manage_add.php");
        exit();
    }
}else{
    //引入html模板头部
    include_once 'inc/header.html';
    //引入html模板左边
    include_once 'inc/left.html';
    //引入html模板主体
    include_once 'inc/manage_add.html';
    //引入html模板底部
    include_once 'inc/footer.html';
}

