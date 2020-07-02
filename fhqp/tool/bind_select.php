<?php
//session_start();
error_reporting(0);
include_once 'config/config.php';

$post = array();

$code = $_GET['code'];

$common = new config();

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
  
  $unionid = $result1['unionid']; 
  
  // $nickname = $result1['nickname']; 
  
  // $headimgurl = $result1['headimgurl']; 

}

if($unionid==''){
	echo '<h2>验证信息丢失，请重新从公众号进入（不要刷新页面）</h2>';die;
}

$urls = $common->agency_bind_check_url();

$back_data = array();

foreach ($urls as $k => $v) {
	$url = $v.'?action=check_agency&unionid='.$unionid;
	$bind_res = $common->http_curl($url);
	$back_info = json_decode($bind_res,true);

	if($back_info['code']!=0){
		$back_data[$k]['url'] = $back_info['login_url'];
		$back_data[$k]['select_name'] = $back_info['name'];
	}
}




if(empty($back_data)){
	header("Location: bind_select_choose.php?uid=$unionid");
}


?>



<!DOCTYPE html>
<html>
	
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		
		<link rel="stylesheet" type="text/css" href="../static/css/default.css">
		
		<script src="../static/js/jquery-2.0.0.js"></script>
		
		<title>烽火棋牌</title>
	
	</head>

<body>
	
	<div style="padding:20px 10px">
		
		<h2>请选择你要登陆的代理后台</h2>
					
		<select class="select" id='select_url'>
			
			<?php foreach ($back_data as $k => $v) { ?>
				<option value="<?php echo $v['url'];?>"><?php echo $v['select_name'];?></option>
			<?php } ?>		

		</select>

		<br>
		
		<input type="button" class="button" value="确定登陆" id="sure_jump">
		<input type="hidden" id='login_url' value="<?php echo $back_data[1]['url'];?>">

		<div style="padding:10px 0px 20px 5px;font-size:13px;">
		
			<span style="color:red">* 请选择你要登陆的代理后台</span><br>		
			* 房卡代理请加官方微信：fhkf008
		
		</div>
		
		<div>
			<a href="bind_select_choose.php?uid=<?php echo $unionid;?>">绑定其它游戏的代理后台</a>
		</div>

	</div>
	<script>
		$('#select_url').on('change select',function(){
			$('#login_url').val($(this).val());
		})
		$('#sure_jump').on('click input',function(){
			var jump_url = $('#login_url').val()+'&uid'+"=<?php echo $unionid;?>";
			window.location.href = jump_url;
		})
	</script>
</body>

</html>