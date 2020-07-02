<?php
include_once 'config/config.php';

$common = new config();

$config = $common->get_config_info();

$appid = $config['appid'];

$state = $_GET['state'];

$redirect_uri = 'http%3a%2f%2ffhqp.yzbmsh.cn%2ftool%2fcharge_myself.php';

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>获取充值用户信息</title>
	<script type="text/javascript" src="../static/js/jquery-2.0.0.js"></script>
</head>
<body>
<script>
	function auto_click(){
		location.href = location.href="<?php echo $url;?>";
	}
	
	var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
	if (ua.match(/MicroMessenger/i) == "micromessenger") {
		auto_click();
	}
	
</script>
</body>
</html>