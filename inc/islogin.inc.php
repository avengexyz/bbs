<?php
//引入数据库配置文件
include_once 'config.inc.php';
//引入数据库操作文件
include_once 'mysql.inc.php';


function is_login(){
    if(isset($_COOKIE['sfk']['name']) && isset($_COOKIE['sfk']['pw'])){
        $link=connect();
        $query="select *from sfk_member where name='{$_COOKIE['sfk']['name']}' and pw='{$_COOKIE['sfk']['pw']}' ";
        $result=execute($link,$query);
        if(mysqli_num_rows($result)==1){
			$data=mysqli_fetch_assoc($result);
            return $data['id'];
        }else{
            return false;
        }
    }else{
        return false;
    }
}
