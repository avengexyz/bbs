<?php

/*
参数说明：
$count：总记录数
$page_size：每页显示的记录数
$num_btn：要展示的页码按钮数目
$page：分页的get参数
*/

//分页函数
function page($count,$page_size,$num_btn=10,$page='page'){

    //解决limit输出负数导致sql语句出错
    if($count==0){//如果总数是0直接返回空
        $data=array(
            'limit'=>'',
            'html'=>''
        );
        return $data;
    }

    //如果是空数据 或者不是一个数字 或者非法数字比如-1 就赋值页码为1
    if(!isset($_GET[$page]) || !is_numeric($_GET[$page])  || $_GET[$page]<1 ){
        $_GET[$page]=1;
    }

    //总页码数
    $page_num_all=ceil($count/$page_size);

    //如果传过来的页码数超过最大页码数 就重新赋值为最大页码数
    if($_GET[$page] > $page_num_all){
        $_GET[$page] = $page_num_all;
    }

    //计算数据库limit查询开始行号
    $start=($_GET[$page]-1)*$page_size;
    $limit="limit {$start},{$page_size}";

    // echo '当前页：'.$_GET[$page].'<br />';
    
    //适用所有页面
    //($_SERVER['REQUEST_URI'])获取当前url
    $current=$_SERVER['REQUEST_URI'];
    //parse_url($current)本函数解析一个 URL 并返回一个关联数组，包含在 URL 中出现的各种组成部分。
    //var_dump可以看到解析成了两部分 ["path"]=>"/test.php" ["query"]=>"page=7"
    $arr_current=parse_url($current);
    $current_path=$arr_current['path'];
    $url='';
    if(isset($arr_current['query'])){
        // parse_str()将字符串解析成多个变量
        parse_str($arr_current['query'],$arr_query);//将解析的字符串分割写进一个关联数组
        unset($arr_query[$page]);//unset() 销毁指定的变量。
        //判断一下如果只有一个get参数page被我们删掉了 就直接输出
        //如果有多个参数 删掉page
        if(empty($arr_query)){
            $url="{$current_path}?{$page}=";//输出 "/test.php?page="
        }else{
            //http_build_query()根据数组产生一个urlencode之后的请求字符串
            //就是将几个参数合成字符串并且中间加&比如id=1&name=2
            $other=http_build_query($arr_query);
            $url="{$current_path}?{$other}&{$page}=";//输出 "/test.php?id=1&page="
        }
    }else{
        $url="{$current_path}?{$page}=";//输出 "/test.php?page="
    }
    
    //如果要展示的页码数大于等于总页码数 显示全部要展示的页码按钮
    //反过来说就是总页码数小于要展示的页码数 则显示全部 比如总共就10页或者更多 规定要显示10个按钮就全部显示
    $html=array();
    if($num_btn>=$page_num_all){
        for($i=1;$i<=$page_num_all;$i++){//这边的$page_num_all即是限制循环次数以控制按钮数目的变量 $i是页码号
            //如果不是当前页输出a标签可以点 是就是span不能点
            //.=的时候后面加个空格就有间距了
            if($_GET[$page]==$i){
                $html[$i]="<span>{$i}</span>";
            }else{
                $html[$i]="<a href='{$url}{$i}'>{$i}</a>";
            }
        }
    }else{
        //如果总页码数大于要显示的页码数 则只显示要显示的页码数量 比如有12页规定显示是个按钮就显示10个按钮
        $num_left=floor(($num_btn-1)/2);//floor()向下取整 最左侧页码号
        //起始的页码号
        $start=$_GET[$page]-$num_left;
        //最右侧页码数
		$end=$start+($num_btn-1);
        // echo '结束按钮号'.$end.'<br />';
        //如果页码数小于1强制赋值为1 以免出现-1的情况
		if($start<1){
			$start=1;
        }
        //如果结束页码数大于总页码数 强制赋值为最大页码数 以免出现多出页码id的情况        
		if($end>$page_num_all){
			$start=$page_num_all-($num_btn-1);
		}
		for($i=0;$i<$num_btn;$i++){
            //如果不是当前页输出a标签可以点 是就是span不能点
            //.=的时候后面加个空格就有间距了
			if($_GET[$page]==$start){
				$html[$start]="<span>{$start}</span>";
			}else{
				$html[$start]="<a href='{$url}{$start}'>{$start}</a>";
			}
			$start++;
        }

        //如果按钮数目大于等于3的时候做省略号效果 其实就是首页尾页
        if(count($html)>=3){
            //reset()将数组指向第一个单元
            // reset($html);
            //key()返回数组当前单元的键名
            // echo key($html);
            //current()返回数组中当前元素的值 就是那段html代码
            // echo current($html);
            //end()将数组指向最后一个单元
            // echo end($html);
            reset($html);
            $keyfrist=key($html);
            end($html);
            $keyend=key($html);
            if($keyfrist!=1){
                //array_shift()将数组开头的单元移出数组
                array_shift($html);
                // array_unshift();在数组开头插入一个或多个单元
                array_unshift($html,"<a href='{$url}1'>1...</a>");
            }
            if($keyend!=$page_num_all){
                //array_pop()将数组最后一个单元移出数组
                array_pop($html);
                // array_push();在数组结尾插入一个或多个单元
                array_push($html,"<a href='{$url}{$page_num_all}'>...{$page_num_all}</a>");
            }
        }

    }
    
    //上一页下一页
    //如果当前页不等于一就加个上一页
    if($_GET[$page]!=1){
        $prev=$_GET[$page]-1;
        // array_unshift();在数组开头插入一个或多个单元
        array_unshift($html,"<a href='{$url}{$prev}'>《上一页</a>");
    }
    //如果当前页不等于最大页就加个下一页
    if($_GET[$page]!=$page_num_all){
        $next=$_GET[$page]+1;
        // array_push();在数组结尾插入一个或多个单元
        array_push($html,"<a href='{$url}{$next}'>下一页》</a>");
    }


    //输出html代码
    //implode()把数组元素组合为字符串
    $html=implode(" ",$html);
    $data=array(
        'limit'=>$limit,
        'html'=>$html
    );
    return $data;
}