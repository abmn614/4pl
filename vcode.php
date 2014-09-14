<?php 
/**
 * 需求：实现验证码
 * 方法：imagettftext()
 */
/**
 * 验证码函数vcode
 * mixed vcode(int $width, int $height, int $x, int $y, str $fontfile, int $fontsize, int $angle, int vstrnum, int $interpixelnum, int $interlinenum);
 * $width           画布宽度
 * $height          画布高度    
 * $x               起始x轴坐标
 * $y               起始y轴坐标
 * $fontfile        font文件名相对路径
 * $fontsize        字体大小
 * $angle           字体旋转角度，逆时针
 * $vstrnum         验证码字符个数
 * $interpixelnum   干扰像素点个数
 * $interlinenum    干扰线条数
 */
 
function vcode($width,$height,$x,$y,$fontfile,$fontsize,$angle,$vstrnum,$interpixelnum,$interlinenum){

// 开启session
session_start();

// 创建画布资源
$width = 100;
$height = 30;
$im = imagecreatetruecolor($width, $height);

// 准备颜色
$bgcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
$fontcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
$interpixelcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
$interlinecolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));

// 填充画板
imagefill($im, 0, 0, $bgcolor);

// 准备文字

$strarr = array_merge(range(0, 9), range(a, z), range(A, Z));
shuffle($strarr);
$str = join('',array_slice($strarr, 0, $vstrnum));

// 将验证码的值保存到session里
$_SESSION['vcode'] = $str;

$angle = 0; //角度
imagettftext($im, $fontsize, $angle, $x, $y, $fontcolor, $fontfile, $str);

for ($i=0; $i < $interpixelnum; $i++) { 
    imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $interpixelcolor);
}
for ($i=0; $i < $interlinenum; $i++) { 
    imageline($im, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $interlinecolor);
}

// 输出图片
header("content-type:image/png;charset=utf8");
imagepng($im);

// 关闭资源
imagedestroy($im);

}

vcode(100,30,20,25,'fonts/simkai.ttf',22,0,4,300,5);

 ?>