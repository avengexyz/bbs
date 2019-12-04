<?php
//这个是解决乱码问题
header("Content-type:text/html;charset=utf-8");

if(empty($_POST['content'])){
    echo "内容不得为空！";
    // 3秒后跳转到父板块
    header("refresh:3;url=../quote.php?id={$_GET['id']}&reply_id={$_GET['reply_id']}");
    exit();
}
if(mb_strlen($_POST['content'])>255){
    echo "内容不得超过255个字符！";
    // 3秒后跳转到父板块
    header("refresh:3;url=../quote.php?id={$_GET['id']}&reply_id={$_GET['reply_id']}");
    exit();
}
