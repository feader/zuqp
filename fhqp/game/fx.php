<?php
include_once '../config/config.php';

//$state = '1-1';
//前面是用户uid，后面游戏id

$state = $_GET['state'];

$part = explode('-',$state);

$game_id = $part[1];

$uid = $part[0];

$common = new config($game_id);

$config = $common->get_config_info();

$appid = $config['appid'];

$redirect_uri = 'http%3a%2f%2ffhqp.yzbmsh.cn%2fgame%2ffx1.php';

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";
// $url = $common->jump_url($game_id);
// $url = $url.'index.html?uid='.$uid;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>用户分享链接</title>
	<script type="text/javascript" src="../static/js/jquery-2.0.0.js"></script>
</head>
<body>
<script>
	function auto_click(){
		location.href = location.href="<?php echo $url;?>";
	}
	
	// var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
	// if (ua.match(/MicroMessenger/i) == "micromessenger" && navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad|Windows Phone)/i)) {
	// if (ua.match(/MicroMessenger/i) == "micromessenger") {
		auto_click();
	// }else{
	// 	alert('请在微信里打开链接！');
	// }
	
</script>
</body>
</html>