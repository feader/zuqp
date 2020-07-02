<?php
include_once '../config/config.php';

//$state = 'hg0001-1';
//前面是代理id，后面游戏id

$state = $_GET['state'];

$part = explode('-',$state);

$game_id = $part[1];

$auid = $part[0];

$common = new config($game_id);

$config = $common->get_config_info();

$appid = $config['appid'];

$redirect_uri = 'http%3a%2f%2ffhqp.yzbmsh.cn%2fgame%2fwx1.php';

$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";

// $url = $common->jump_url($game_id);
// $url = $url.'index.html?auid='.$auid;


$agent_ip = $_SERVER['REMOTE_ADDR'];
// var_dump($agent_ip);die;
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>代理推广链接</title>
	<script type="text/javascript" src="../static/mcatom/js/jquery-2.0.0.js"></script>
</head>
<body>
<script>
	function auto_click(){
		location.href = location.href="<?php echo $url;?>";
	}
	function auto_click1(nw_url){
		location.href = location.href=nw_url;
	}
	var ua = navigator.userAgent.toLowerCase();//获取判断用的对象
	// if (ua.match(/MicroMessenger/i) == "micromessenger" && navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad|Windows Phone)/i)) {
	if (ua.match(/MicroMessenger/i) == "micromessenger") {
		auto_click();
	}else{
		//var nw_url = 'http://houtai.tqfy0.com/wx1.php?state='+"<?php echo $state.'-'.$agent_ip;?>";
		var nw_url = '<?php echo $url;?>';
		console.log(nw_url);
		auto_click1(nw_url);
		// alert("<?php echo $agent_ip;?>");
	}
	
</script>
</body>
</html>
