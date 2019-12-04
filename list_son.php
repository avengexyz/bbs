<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';
//引入分页操作文件
include_once 'inc/page.inc.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    //is_numeric()检测变量是否为数字或数字字符串
    echo "子版块id参数不合法!";
    // 3秒后跳转到父板块
    header("refresh:3;url=./index.php");
    exit();
}

//然后根据板块id查询有没有这个板块
$link=connect();
$query="select * from sfk_son_module where id={$_GET['id']}";
$result_father=execute($link, $query);
if(mysqli_num_rows($result_father)==0){
    echo "子版块不存在!";
    // 3秒后跳转到父板块
    header("refresh:3;url=./index.php");
    exit();
}
//将查询到的子板块数据处理 以便html输出
$data_son=mysqli_fetch_assoc($result_father);

//查询子板块的总帖数
$query="select count(*) from sfk_content where module_id={$_GET['id']}";
$count_all=num($link,$query);

//查询子板块下今日发帖数
$query="select count(*) from sfk_content where module_id={$_GET['id']} and time>CURDATE()";
$count_today=num($link,$query);

//查询子板块版主和板块简介
$query="select sfk_son_module.info,sfk_member.name from sfk_son_module,sfk_member where sfk_son_module.id={$_GET['id']} and sfk_son_module.member_id=sfk_member.id";
$son=execute($link, $query);
$son=mysqli_fetch_assoc($son);
// var_dump($son) ;





//分页
$page=page($count_all,1);

//查询帖子标题等详细信息 用于html输出
$query="SELECT 
sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo,sfk_son_module.module_name
FROM
sfk_content,sfk_member,sfk_son_module
WHERE
sfk_content.module_id={$_GET['id']}
AND
sfk_content.member_id = sfk_member.id
AND
sfk_content.module_id = sfk_son_module.id
 {$page['limit']} 
";
$result_content=execute($link, $query);



//查询侧边栏板块信息数据
$query="select * from sfk_father_module";
$result_father1=execute($link,$query);





//引入头部模板
include_once 'index/inc/header.html';
//引入主体模板
include_once 'index/inc/list_son.html';
//引入尾部模板
include_once 'index/inc/footer.html';
?>