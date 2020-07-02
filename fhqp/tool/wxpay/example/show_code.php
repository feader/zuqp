<?php
define('IN_DATANG_SYSTEM', true);
require_once "../../../../../config/config.php";
require_once '../../../../include/global2.php';
global $db;

$src = $_GET['src'];

$oid = $_GET['oid'];

$setting_sql = "select setting_value from t_system_setting where setting_name = 'web_url'";

$setting = $db->get_one_info($setting_sql);

$back_url = $setting['setting_value'].'web/admin/module/agency/index.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>二维码识别</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<script type="text/javascript" src="../../../../static/js/jquery.min.js"></script>
	<style>
		body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,button,textarea,p,blockquote,th,td { margin:0; padding:0; }
	</style>
</head>
<body>
	<div style="width:100%;">
		<img src="<?php echo $src;?>" style='width:250px;height:250px;margin:0 auto;display:block;'>
	</div>
	<div style="width:100%;">
		<p style="text-align:center;color:red;">还无法二维码识别的手机用户可以点击这里刷新页面，即可二维码识别</p>
		<br>
		<p style="text-align:center;">
			<input type="button" value='点我刷新' id="reflesh">
		</p>	
		<br>
		<p style="text-align:center;">
			<a href="<?php echo $back_url;?>">返回代理后台</a>
		</p>
	</div>
<script>
function get_order_res(){		
	var order_id = <?php echo "'$oid'";?>;
	$.ajax({
        dataType:'json',
        url:'../../recharge_wxpay.php?action=get_order_res',
        type:'get',
        data:{order_id:order_id},
        success:function(res){
            if(res){
            	alert('支付完成！');
            	window.location.href = '../../agency_recharge_log.php';
            }
        }
    })
}

$('#reflesh').click(function(){
	window.location.reload();
})

function auto_check(){
	get_order_res();
    setInterval("get_order_res()",5000);
}
auto_check();	
</script>	
</body>
</html>