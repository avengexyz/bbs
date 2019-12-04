<?php
header("Content-type:text/html;charset=utf-8");
//引入数据库配置文件
include_once './config.inc.php';
//引入数据库操作文件
include_once './mysql.inc.php';

session_start();

if(!isset($_SESSION['name'])){
    echo "未登录,请登陆后在修改头像";
    // 3秒后跳转到父板块
    header("refresh:3;url=./login.php");
    exit;
}

//检测有没有提交 提交了$_FILES会有数据
if(isset($_FILES['file'])){

    //检测图片类型
    //首先设定一个数组包含了允许上传的图片类型
    //然后in_array()检测一下 in_array() 函数搜索数组中是否存在指定的值。
    $type=array("image/jpeg","image/jpg","image/pjpeg");
    if(!in_array($_FILES['file']['type'],$type)){
        echo "不支持的文件格式";
        // 3秒后跳转到父板块
        header("refresh:3;url=../member_photo_update.php");
        exit;
    }

    //检测图片大小
    if($_FILES['file']['size']>2*1024*1024){
        echo "图片过大,只支持2M内大小的图片";
        // 3秒后跳转到父板块
        header("refresh:3;url=../member_photo_update.php");
        exit;
    }

    //判断是否是通过表单POST上传
    //is_uploaded_file() 函数检查指定的文件是否是通过 HTTP POST 上传的。
    if(!is_uploaded_file($_FILES['file']['tmp_name'])){
        echo "非法上传";
        // 3秒后跳转到父板块
        header("refresh:3;url=../member_photo_update.php");
        exit;
    }

    //检测存放图片目录是否存在没有就创建一个 file_exists() 函数检查文件或目录是否存在。
    //这是一种方式 每个人新建个文件夹 还有一种方式 直接重命名文件
    // $save_path=$_SERVER['DOCUMENT_ROOT']."/uploads/".time();
    // if(!file_exists($save_path)){
    //     mkdir($save_path,0777);
    // }

    //定义上传文件的存放路径
    $save_path = $_SERVER['DOCUMENT_ROOT']."/uploads/";

    //通过分割获取图片的后缀
    //explode() 函数使用一个字符串分割另一个字符串，并返回由字符串组成的数组。
    $array = explode('.',$_FILES['file']['name']);
    $suffix = ($array[1]);

    //设置默认时区
    date_default_timezone_set("Asia/Shanghai");

    //将上传图片重命名为日期加100-999的随机数并加上后缀名
    $rename = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$suffix;

    //将上传图片的缓存存入文件夹并写入数据库 move_uploaded_file() 函数把上传的文件移动到新位置。
    if(move_uploaded_file($_FILES['file']['tmp_name'],$save_path.$rename)){
        $photo="/uploads/".$rename;
        $link=connect();
        $query="update sfk_member set photo='{$photo}' where id={$_SESSION['member_id']}";
        $result=execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            echo "上传成功";
            // 3秒后跳转到父板块
            header("refresh:3;url=../member_photo_update.php");
            exit;
        }else{
            echo "上传失败";
            // 3秒后跳转到父板块
            header("refresh:3;url=../member_photo_update.php");
            exit;
        }

    }else{
        echo "上传失败";
        // 3秒后跳转到父板块
        header("refresh:3;url=../member_photo_update.php");
        exit;
    }

}else{
    echo "未上传任何内容";
    // 3秒后跳转到父板块
    header("refresh:3;url=../member_photo_update.php");
    exit;
}