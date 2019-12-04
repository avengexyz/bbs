<?php
echo "<pre>";
var_dump($_SERVER);

// header("location:{$_SESSION['SCRIPT_NAME']}");
// echo $_SERVER['SCRIPT_NAME'];

//如果检测到有上一次的网址就跳到上一页
//没有检测到就赋一个网址 然后在跳过去
if(isset($_SERVER['HTTP_REFERER'])){
    header("refresh:3;url={$_SERVER['HTTP_REFERER']}");
}else{
    $_SERVER['HTTP_REFERER']='index.php';
    header("refresh:3;url={$_SERVER['HTTP_REFERER']}");
}
// header("refresh:3;url={$_SERVER['HTTP_REFERER']}");

?>

