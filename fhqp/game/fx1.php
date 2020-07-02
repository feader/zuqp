<?php
error_reporting(0);
include_once '../config/config.php';

$post = array();

$code = $_GET['code'];

$state = $_GET['state'];

$part = explode('-',$state);

$gamer_uid = $part[0];

$post['gamer_uid'] = $gamer_uid;

$game_id = $part[1];

$common = new config($game_id);

$config = $common->get_config_info();

if(isset($code)&&!empty($code)){
  
  $appid = $config['appid'];

  $secret = $config['secret'];

  $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
    
  $res = $common->http_curl($url);
    
  $result = json_decode($res,true);

  $access_token = $result['access_token'];

  $openid = $result['openid'];

  $url1 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
  
  $res1 = $common->http_curl($url1);

  $result1 = json_decode($res1,true);
  
  $post['unionid'] = $result1['unionid']; 

}

$post_url = $common->get_gamer_to_gamer_url($game_id);

$post_res = $common->curl_post($post_url,$post);
// var_dump($post_url);
// var_dump($post);
// var_dump($res1);
// var_dump($post_res);
// die;
$jump_url = $common->jump_url($game_id);




?> 



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>烽火棋牌</title>
</head>
<body>
	<!-- <p>游戏下载页</p> -->
</body>
<script>
	function auto_click(){
		location.href = location.href="<?php echo $jump_url;?>";
	}
	auto_click();
</script>
</html>


