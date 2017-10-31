<?php

$code = $_GET['code'];

$state = $_GET['state'];

if(isset($code)&&!empty($code)){
  
	$appid = 'wxf09b5c7c01706dde';

	$secret = '00da60a644e5a391714388555b19c557';

	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
	    
	$res = http_curl($url);
	    
	$result = json_decode($res,true);

	$access_token = $result['access_token'];

	$openid = $result['openid'];

}

function http_curl($url){   
  	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
	$data = curl_exec($curl);
	curl_close($curl);
	//var_dump($data);
  	return $data; // 返回数据  
}  

$jump_url = "http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/module/agency/wxpay/example/jsapi.php?openid=$openid&product_id=$state";

?> 



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>请稍候~</title>
</head>
<body>
	<!-- <p>游戏下载页</p> <-->
</body>
<script>
	function auto_click(){
		location.href = location.href="<?php echo $jump_url;?>";
	}
	auto_click();
</script>
</html>