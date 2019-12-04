<?php
//验证码图片大小
$width = 100;
$high = 30;

//创建画布
$img=imagecreatetruecolor($width, $high);

//画布背景色
$gray = imagecolorallocate($img,200,200,200);

// 填充画布背景
imagefill($img,0,0,$gray);

//字体颜色
$color = imagecolorallocate($img,mt_rand(0,125),mt_rand(0,125),mt_rand(0,125));

// 设置背景干扰元素
for ($i = 0; $i < 200; $i++) {
    $pointcolor = imagecolorallocate($img, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
    imagesetpixel($img, mt_rand(1, 99), mt_rand(1, 29), $pointcolor);
}
//设置干扰线
for ($i = 0; $i < 3; $i++) {
    $linecolor = imagecolorallocate($img, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
    imageline($img, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $linecolor);
}
//验证码长度
$length = 4;
// 生成验证码字符串
$str = substr(str_shuffle('ABCDEFGHIJKLMNPQRSTUVWXYZ23456789abcdefghijkmnpqrstuvwxyz'),0,$length);

//验证码字体大小
$fontsize = 25;
//生成验证码
imagettftext($img,$fontsize,0,4,20,$color,'../index/style/ManyGifts.ttf',$str);

//向session保存验证码数据
// 开启session
session_start();
//将验证码字符串赋给变量
//创建一个变量存储产生的验证码数据，便于用户提交核对
$captcha = "";
$captcha .= $str;
//写入session
$_SESSION["captcha"] = $captcha;

// 向浏览器输出图片头信息
header("content-type:image/png");
//输出图片到浏览器
imagepng($img);
// 销毁画布
imagedestroy($img);

?>