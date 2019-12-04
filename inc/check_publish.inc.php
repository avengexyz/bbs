<?php
if(empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
    echo "所属版块id不合法！";
    // 3秒后跳转到父板块
    header("refresh:3;url=./publish.php");
    exit();
}
$query="select * from sfk_son_module where id={$_POST['module_id']}";
$link=connect();
$result=execute($link, $query);
if(mysqli_num_rows($result)!=1){
    echo "所属版块不存在！";
    // 3秒后跳转到父板块
    header("refresh:3;url=./publish.php");
    exit();
}
if(empty($_POST['title'])){
    echo "标题不得为空！";
    // 3秒后跳转到父板块
    header("refresh:3;url=./publish.php");
    exit();
}
if(mb_strlen($_POST['title'])>255){
    echo "标题不得超过255个字符！";
    // 3秒后跳转到父板块
    header("refresh:3;url=./publish.php");
    exit();
}
?>