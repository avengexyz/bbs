<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';


if(isset($_POST['submit'])){
    //链接数据库
    $link=connect();
    //引入注册判断文件
    include_once 'inc/check_register.inc.php';
    //没有问题进入下一步 对数据进行转义
    $_POST=escape($link,$_POST);
    //进行注册操作
    $query="insert into sfk_member(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
    execute($link,$query);
    // echo $query;
    if(mysqli_affected_rows($link)==1){
        echo ('注册成功');
        setcookie('sfk[name]',$_POST['name']);
        setcookie('sfk[pw]',md5($_POST['pw']));

    }else{
        echo ('注册失败');
    }
    //3秒后跳转到父板块
    header("refresh:3;url=register.php");

}else{
    //引入头部模板
    include_once 'index/inc/header.html';
    //引入主体模板
    include_once 'index/inc/register.html';
    //引入尾部模板
    include_once 'index/inc/footer.html';
}
?>