<?php
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

//获取get数据
$id=$_GET['id'];
//查询子板块数据
$link=connect();
$query="select * from sfk_son_module where id=$id";
$result=execute($link,$query);
$row1=mysqli_fetch_all($result,MYSQLI_ASSOC);
//查询父板块关联信息
$link=connect();
$query="select * from sfk_father_module";
$result=execute($link,$query);
$row=mysqli_fetch_all($result,MYSQLI_ASSOC);

if(isset($_POST['submit'])){
    $link=connect();
    $query="update sfk_son_module set father_module_id='{$_POST['father_module']}' , module_name='{$_POST['module_name']}' , info='{$_POST['info']}' , member_id='{$_POST['member_id']}' , sort='{$_POST['sort']}'  where id='$id'";
    //测试一下sql语句是否正常
    // echo $query;
    execute($link,$query);
    //判断成功或者失败
    //mysqli_affected_rows(检测sql操作影响的行数)
    if(mysqli_affected_rows($link)==1){
        echo ('修改成功');
        //3秒后跳转到父板块
    header("refresh:3;url=son_module.php");
    }else{
        echo ('修改失败');
        //3秒后跳转到父板块
    header("refresh:3;url=son_module.php");
    }
}else{
    //引入html模板头部
    include_once 'inc/header.html';
    //引入html模板左边
    include_once 'inc/left.html';
    //引入html模板主体
    include_once 'inc/son_module_update.html';
    //引入html模板底部
    include_once 'inc/footer.html';
}



?>