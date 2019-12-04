<?php
if(empty($_POST['name'])){
    echo "管理员名称不得为空！";
    // 3秒后跳转到父板块
    header("refresh:3;url=../admin/manage_add.php");
    exit();
}
if(mb_strlen($_POST['name'])>32){
    echo "管理员名称不得超过255个字符！";
    // 3秒后跳转到父板块
    header("refresh:3;url=../admin/manage_add.php");
    exit();
}
if(mb_strlen($_POST['pw'])<6){
    echo "密码不得小于6个字符！";
    // 3秒后跳转到父板块
    header("refresh:3;url=../admin/manage_add.php");
    exit();
}

$link=connect();
$_POST=escape($link,$_POST);
$query="select * from sfk_manage where name='{$_POST['name']}'";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
    echo "管理员名称重名！";
    // 3秒后跳转到父板块
    header("refresh:3;url=../admin/manage_add.php");
    exit();
}


//简化写法
if(!isset($_POST['level'])){
    $_POST['level']=1;
}elseif($_POST['level']=='0'){
    $_POST['level']=0;
}elseif($_POST['level']=='1'){
    $_POST['level']=1;
}else{
    $_POST['level']=1;
}
