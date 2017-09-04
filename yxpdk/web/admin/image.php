<?php
 @session_start();
 function random($len)
 {
  
   $str="0123456789";
   $s="";
   for($i=0;$i <$len;$i++){
   $s.=$str[rand(0,9)];
   
  }
 return strtolower($s);
 }
 $code=random(4); //随机生成的字符串
 $width = 50; //验证码图片的宽度
 $height = 20; //验证码图片的高度

 @header("Content-Type:image/png");
 $_SESSION["code"] = $code;

 $im=imagecreate($width,$height);
 //背景色
 $back=imagecolorallocate($im,255, 255, 255);
 //模糊点颜色
 $pix=imagecolorallocate($im,187,230,247);
 //字体色
 $font=imagecolorallocate($im,41,163,238);
 //绘模糊作用的点
  for($i=0;$i <1000;$i++)
 {
  imagesetpixel($im,rand(0,$width),rand(0,$height),$pix);
 }
 imagestring($im, 5, 7, 2,$code, $font);
 imagerectangle($im,0,0,$width-1,$height-1,$font);
 imagepng($im);
 imagedestroy($im);

?>