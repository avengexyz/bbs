<?php
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

//查询父板块信息
$link=connect();
$query="select * from sfk_father_module";
$result=execute($link,$query);
$row=mysqli_fetch_all($result,MYSQLI_ASSOC);

if(isset($_POST['submit'])){
    $link=connect();
    $query="insert into sfk_son_module(father_module_id,module_name,info,member_id,sort) values ('{$_POST['father_module']}','{$_POST['module_name']}','{$_POST['info']}','{$_POST['member_id']}','{$_POST['sort']}')";
    //测试一下sql语句是否正常
    // echo $query;
    execute($link,$query);
    //判断成功或者失败
    //mysqli_affected_rows(检测sql操作影响的行数)
    if(mysqli_affected_rows($link)==1){
        echo ('添加成功');
        //3秒后跳转到父板块
    header("refresh:3;url=son_module_add.php");
    }else{
        echo ('添加失败');
        //3秒后跳转到父板块
    header("refresh:3;url=son_module_add.php");
    }
}else{
    //引入html模板头部
    include_once 'inc/header.html';
    //引入html模板左边
    include_once 'inc/left.html';
    //引入html模板主体
    include_once 'inc/son_module_add.html';
    //引入html模板底部
    include_once 'inc/footer.html';
}

?>