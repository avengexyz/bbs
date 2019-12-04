<?php
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';

//获取get数据
$id=$_GET['id'];

//删除父板块数据
$link=connect();
$query="delete from sfk_father_module where id={$id}";
// echo $query;
execute($link,$query);
//mysqli_affected_rows(检测sql操作影响的行数)
if(mysqli_affected_rows($link)==1){
    echo ('删除成功');
}else{
    echo ('删除失败');
}
//3秒后跳转到父板块
header("refresh:3;url=father_module.php");

?>