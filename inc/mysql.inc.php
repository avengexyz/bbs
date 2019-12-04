<?php
//数据库连接
function connect($host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$database=DB_DATABASE,$port=DB_PORT){
    $link=@mysqli_connect($host,$user,$password,$database,$port);
    //mysqli_connect_errno() 返回连接的错误代码 没有错误返回0
    //(mysqli_connect_error() 返回错误信息
    if(mysqli_connect_errno()){
        exit(mysqli_connect_error());
    }
    mysqli_set_charset($link,'utf8');
    return $link;
}
//执行一条sql语句,返回结果集对象或者布尔值
function execute($link,$query){
    $result=mysqli_query($link,$query);
    //mysqli_connect_errno() 返回连接的错误代码 没有错误返回0
    //(mysqli_connect_error() 返回错误信息
	if(mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $result;
}
//执行一条sql语句,返回布尔值
function execute_bool($link,$query){
    //mysqli_real_query()只返回布尔值
    $bool=mysqli_real_query($link,$query);
    //mysqli_connect_errno() 返回连接的错误代码 没有错误返回0
    //(mysqli_connect_error() 返回错误信息
	if(mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $bool;
}
//一次执行多条sql语句
/*
 一次性执行多条SQL语句
$link：连接
$arr_sqls：数组形式的多条sql语句
$error：传入一个变量，里面会存储语句执行的错误信息
使用案例：
$arr_sqls=array(
	'select * from sfk_father_module',
	'select * from sfk_father_module',
	'select * from sfk_father_module',
	'select * from sfk_father_module'
);
var_dump(execute_multi($link, $arr_sqls,$error));
echo $error;
*/
function execute_multi($link,$arr_sqls,&$error){
	$sqls=implode(';',$arr_sqls).';';
	if(mysqli_multi_query($link,$sqls)){
		$data=array();
		$i=0;//计数
		do {
			if($result=mysqli_store_result($link)){
				$data[$i]=mysqli_fetch_all($result);
				mysqli_free_result($result);
			}else{
				$data[$i]=null;
			}
			$i++;
			if(!mysqli_more_results($link)) break;
		}while (mysqli_next_result($link));
		if($i==count($arr_sqls)){
			return $data;
		}else{
			$error="sql语句执行失败：<br />&nbsp;数组下标为{$i}的语句:{$arr_sqls[$i]}执行错误<br />&nbsp;错误原因：".mysqli_error($link);
			return false;
		}
	}else{
		$error='执行失败！请检查首条语句是否正确！<br />可能的错误原因：'.mysqli_error($link);
		return false;
	}
}
//获取记录数
function num($link,$sql_count){
	$result=execute($link,$sql_count);
	$count=mysqli_fetch_row($result);
	return $count[0];
}
//数据库入库之前转义,确保，数据能够顺利的入库
function escape($link,$data){
    //is_string()用于检测变量是否是字符串
	if(is_string($data)){
        //mysqli_real_escape_string()转义在 SQL 语句中使用的字符串中的特殊字符。
		return mysqli_real_escape_string($link,$data);
    }
    //is_array()检测是否为数组
	if(is_array($data)){
		foreach ($data as $key=>$val){
			$data[$key]=escape($link,$val);
		}
	}
	return $data;
	//mysqli_real_escape_string($link,$data);
}
//关闭数据库连接
function close($link){
	mysqli_close($link);
}



?>