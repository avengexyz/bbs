<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';

session_start();
$link=connect();

if(!isset($_SESSION['name'])){
    echo "未登录,请登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}

if(!is_numeric($_SESSION['member_id'])){
    echo "会员id参数不合法!请注销重新登陆";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "帖子id参数不合法!";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}

$query="select member_id from sfk_content where id={$_GET['id']}";
$result_content=execute($link, $query);

if(mysqli_num_rows($result_content)==1){
    $data_content=mysqli_fetch_assoc($result_content);
    if($data_content['member_id']=$_SESSION['member_id']){
        if(isset($_POST['submit'])){
            include 'inc/check_publish.inc.php';
            $_POST=escape($link, $_POST);
			$query="update sfk_content set module_id={$_POST['module_id']},title='{$_POST['title']}',content='{$_POST['content']}' where id={$_GET['id']}";
			execute($link, $query);
			if(mysqli_affected_rows($link)==1){
                echo "修改成功!";
                // 3秒后跳转到父板块
                header("refresh:3;url=member.php");
                exit();
			}else{
                echo "修改失败!";
                // 3秒后跳转到父板块
                header("refresh:3;url=member.php");
                exit();
			}
        }else{
            //查询出帖子数据以便修改
            $query="select module_id,title,content from sfk_content where id={$_GET['id']}";
            $result_content1=execute($link, $query);
            $data=mysqli_fetch_assoc($result_content1);
            $data['title']=htmlspecialchars($data['title']);
            $data['content']=htmlspecialchars($data['content']);
            //查询父板块关联信息
            $query="select * from sfk_father_module order by sort desc";
            $result_father=execute($link, $query);
            //引入头部模板
            include_once 'index/inc/header.html';
            //引入主体模板
            include_once 'index/inc/content_update.html';
            //引入尾部模板
            include_once 'index/inc/footer.html';  
        }
    }else{
        echo "这个帖子不属于你，你没有权限删除!";
        // 3秒后跳转到父板块
        header("refresh:3;url=member.php");
        exit();
    }
}else{
    echo "帖子不存在";
    // 3秒后跳转到父板块
    header("refresh:3;url=member.php");
    exit();
}
