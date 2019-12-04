<?php
//引入数据库配置文件
include_once 'inc/config.inc.php';
//引入数据库操作文件
include_once 'inc/mysql.inc.php';
//引入分页操作文件
include_once 'inc/page.inc.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    //is_numeric()检测变量是否为数字或数字字符串
    echo "帖子参数不合法!";
    // 3秒后跳转到父板块
    header("refresh:3;url=./index.php");
    exit();
}


//然后根据板块id查询有没有这个帖子
//查的同时可以顺便把要显示的帖子内容查出来
$link=connect();
$query="select 
sc.id cid,sc.module_id,sc.title,sc.content,sc.time,sc.member_id,sc.times,sm.name,sm.photo 
from 
sfk_content sc,
sfk_member sm 
where 
sc.id={$_GET['id']}
and
sc.member_id=sm.id";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==0){
    echo "帖子不存在!";
    // 3秒后跳转到父板块
    header("refresh:3;url=./index.php");
    exit();
}

//查询子板块名称
$data_content=mysqli_fetch_assoc($result_content);

//阅读数加1
$query="update sfk_content set times=times+1 where id={$_GET['id']}";
execute($link,$query);

// var_dump($data_content);exit;
$query="select * from sfk_son_module where id={$data_content['module_id']}";
$result_son=execute($link,$query);
$data_son=mysqli_fetch_assoc($result_son);

//查询父板块数据
$query="select *from sfk_father_module where id={$data_son['father_module_id']}";
$result_father=execute($link,$query);
$data_father=mysqli_fetch_assoc($result_father);

//防止用户html标签注入
//htmlspecialchars() 函数把预定义的字符转换为 HTML 实体
$data_content['title']=htmlspecialchars($data_content['title']);
// $data_content['content']=htmlspecialchars($data_content['content']);
//nl2br（）函数在字符串中的每个新行（\ n）之前插入HTML换行符（<br>或<br />）
$data_content['content']=nl2br(htmlspecialchars($data_content['content']));

//阅读数比实际显示少一次 所以显示之前先加一次
$data_content['times']=$data_content['times']+1;

//分页
$query="select count(*) from sfk_reply where content_id={$_GET['id']}";
$count=num($link,$query);
$page_size=3;
$page=page($count,$page_size);

//查询回复内容
// $query="select * from sfk_reply,sfk_member where sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=sfk_member.id {$page['limit']}";
$query="select sfk_reply.id,sfk_reply.content,sfk_reply.quote_id,sfk_reply.time,sfk_member.photo,sfk_member.name from sfk_reply,sfk_member where sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=sfk_member.id {$page['limit']}";
$result_reply=execute($link,$query);

//回复楼数
$i=($_GET['page']-1)*$page_size+1;

//回复总数
$query="select count(*) from sfk_reply where content_id={$_GET['id']}";
$result=execute($link,$query);
$count=mysqli_fetch_row($result);




//引入头部模板
include_once 'index/inc/header.html';
//引入主体模板
include_once 'index/inc/show.html';
//引入尾部模板
include_once 'index/inc/footer.html'; 