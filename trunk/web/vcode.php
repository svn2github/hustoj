<?
session_start();
//生成验证码图片
Header("Content-type: image/PNG");
$im = imagecreate(44,18);
$back = ImageColorAllocate($im, rand(240,255),rand(240,255),rand(240,255));
imagefill($im,0,0,$back); //背景
srand((double)microtime()*1000000);
//生成4位数字
for($i=0;$i<4;$i++){
$font = ImageColorAllocate($im, rand(100,255),rand(0,100),rand(100,255));
$authnum=rand(1,9);
$vcodes.=$authnum;
imagestring($im, 5, 2+$i*10, 1, $authnum, $font);
}
for($i=0;$i<180;$i++) //加入干扰象素
{ 
$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
} 
ImagePNG($im);
ImageDestroy($im);
$_SESSION['VCODE'] = $vcodes;
?>