<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once '../inc/config.inc.php';
//引入数据库操作文件
include_once '../inc/mysql.inc.php';
$link=connect();


if(isset($_POST['submit'])){
    $_POST=escape($link,$_POST);
	$query="update sfk_info set title='{$_POST['title']}',keywords='{$_POST['keywords']}',description='{$_POST['description']}' where id=1";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
        echo "修改成功";
        // 3秒后跳转到父板块
        header("refresh:3;url=web_set.php");
        exit();
	}else{
        echo "修改失败";
        // 3秒后跳转到父板块
        header("refresh:3;url=web_set.php");
        exit();
	}
}else{
    //查询站点设置数据
    $query="select * from sfk_info";
    $result_info=execute($link, $query);
    $data_info=mysqli_fetch_assoc($result_info);

    //引入html模板头部
    include_once 'inc/header.html';
    //引入html模板左边
    include_once 'inc/left.html';
    //引入html模板主体
    include_once 'inc/web_set.html';
    //引入html模板底部
    include_once 'inc/footer.html';
}

