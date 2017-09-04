<?php
define('IN_DATANG_SYSTEM', true);
require_once "../../../config/config.php";
require_once '../../include/global2.php';
global $db;

$code_url = $_GET['code_url'];

$setting_sql = "select setting_value from t_system_setting where setting_name = 'web_url'";

$setting = $db->get_one_info($setting_sql);

$back_url = $setting['setting_value'].'web/admin/module/agency/index.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>推广二维码保存</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<script type="text/javascript" src="../../../admin/static/js/jquery.min.js"></script>
	<script type="text/javascript" src="../../../admin/static/js/jquery.qrcode.min.js"></script>
	<style>
		body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,button,textarea,p,blockquote,th,td { margin:0; padding:0; }
		#show_qrcode img{display: block;margin: 0 auto;}
	</style>
</head>
<body>
	<div style="width:100%;margin-top:10px;">		
		<div id="qrcode" style="display:none;"></div>
		<div id="show_qrcode" style=></div>
	</div>
	<div style="width:100%;margin-top:10px;">		
		<p style="text-align:center;">
			<a href="<?php echo $back_url;?>">返回代理后台</a>
		</p>
	</div>
<script>
    jQuery('#qrcode').qrcode({
        render  : "canvas",//也可以替换为table
        width   : 300,
        height  : 300,
        text    : "<?php echo $code_url;?>"
    });

    //从canvas中提取图片image
    function convertCanvasToImage(canvas) {
        //新Image对象，可以理解为DOM
        var image = new Image();
        // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持
        // 指定格式PNG
        image.src = canvas.toDataURL("image/png");
        return image;
    }

    //获取网页中的canvas对象
    var mycanvas1=document.getElementsByTagName('canvas')[0];

    //将转换后的img标签插入到html中
    var img = convertCanvasToImage(mycanvas1);
    $('#show_qrcode').append(img);//imgDiv表示你要插入的容器id
</script>
</body>
</html>