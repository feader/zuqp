<?php
error_reporting(0);
include_once '../config/config.php';

$code = $_GET['code'];

$state = $_GET['state'];

$game_id = $state;

$common = new config($game_id);

$config = $common->get_config_info();

$post = array();

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

  $unionid = $result1['unionid'];

  $post['unionid'] = $unionid; 

}

$post_url = $common->get_game_activity_sign_url($game_id);

$post_res = $common->curl_post($post_url,$post);
// var_dump($post_res);die;
// $jump_url = $common->jump_url($game_id);
$show = json_decode($post_res,true);
?> 



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>签到显示页</title>
  <script type="text/javascript" src="../static/js/jquery-2.0.0.js"></script>
  <style>
      .center{text-align: center}
  </style>
</head>
<body>
	<p class='center'>签到信息</p>
  <div style="margin:0 auto;width:50%;border:1px solid blue;">
    <!-- <p class='center'>签到成功！</p>
    <p class='center'>序号：01</p>
    <p class='center'>请把序号报给工作人员完成签到登记！</p> -->
    <?php echo $show['msg'];?>
  </div>
</body>
<script>
	
</script>
</html>


