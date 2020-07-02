<?php
include_once '../config/config.php';

//$state = '1';
//游戏id

$state = $_GET['state'];

$common = new config($state);

$config = $common->get_config_info();

$appid = $config['appid'];

$redirect_uri = 'http%3a%2f%2ffhqp.yzbmsh.cn%2fgame%2factivity_sign1.php';

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>参与活动的用户签到</title>
	<script type="text/javascript" src="../static/js/jquery-2.0.0.js"></script>
</head>
<body>
<script>
	function auto_click(){
		location.href = location.href="<?php echo $url;?>";
	}
	
	auto_click();

</script>
</body>
</html>