<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';
//引入分页操作文件
include_once 'inc/page.inc.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    //is_numeric()检测变量是否为数字或数字字符串
    echo "父版块id参数不合法!";
    // 3秒后跳转到父板块
    header("refresh:3;url=./index.php");
    exit();
}

//然后根据板块id查询有没有这个板块
$link=connect();
$query="select * from sfk_father_module where id={$_GET['id']}";
$result_father=execute($link, $query);
if(mysqli_num_rows($result_father)==0){
    echo "父版块不存在!";
    // 3秒后跳转到父板块
    header("refresh:3;url=./index.php");
    exit();
}
//将查询到的父板块数据处理 以便html输出
$data_father=mysqli_fetch_assoc($result_father);

//查询与父板块关联的子板块
$query="select * from sfk_son_module where father_module_id={$_GET['id']} ";
$result_son=execute($link, $query);
$id_son='';
$son_list='';
while($data_son=mysqli_fetch_assoc($result_son)){
    $id_son.=$data_son['id'].',';
    $son_list.="<a>{$data_son['module_name']}</a>&nbsp";
}

//echo $id_son; 输出测试一下 输出1，2，5，
//trim — 去除字符串首尾处的空白字符（或者其他字符）
$id_son=trim($id_son,',');

//查询父板块下所有子板块的总帖数
$query="select count(*) from sfk_content where module_id in({$id_son})";
$count_all=num($link,$query);

//查询父板块下所有子板块今日发帖数
$query="select count(*) from sfk_content where module_id in({$id_son}) and time>CURDATE()";
$count_today=num($link,$query);

//分页
$page=page($count_all,1);

//查询帖子标题等详细信息 用于html输出
$query="SELECT 
sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo,sfk_son_module.module_name,sfk_son_module.id ssm_id 
FROM
sfk_content,sfk_member,sfk_son_module
WHERE
sfk_content.module_id IN({$id_son}) 
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
include_once 'index/inc/list_father.html';
//引入尾部模板
include_once 'index/inc/footer.html';
?>