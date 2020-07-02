<?php
include_once 'config/config.php';
$uid = $_GET['uid'];
$name = $_GET['name'];
$himg = $_GET['himg'];
$state = $_GET['state'];

$part = explode('-',$state);

$gid = $part[1];

$auid = $part[0];

$common = new config();

$url = $common->get_agency_info_url(2);

$url = $url.'?uid='.$uid;

$post_data = array();

$post_data['uid'] = $uid;

// $res = $common->curl_post($url,$post_data);
$res = $common->http_curl($url);

$decode = json_decode($res,true);

$play_id = $decode['uid'];

$error_code = 0;

if(!$play_id){

	$play_id = '你没登陆过这个游戏';

	$error_code = 1;

}

$dimond = $decode['dimond'];

if(!$dimond){

	$dimond = 0;

}

?>


<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		<title>在线充值</title>
		<link rel="stylesheet" type="text/css" href="../static/css/style.css">
		<script src="../static/js/jquery-2.0.0.js"></script>
	</head>

	<body>
	
		<div style="padding:10px 10px">
			<?php if(!$_SERVER){ ?>	
			<!-- <div style="padding-bottom:5px;">
				<span style='color:red;font-size:16px;'>请先选择游戏：</span>
				<select class="select" style="margin-top:0px;width:150px;margin-left:0px;" id="select_game">					
					<option value="2" >烽火跑得快</option>	
					<option value="3" >烽火掼蛋</option>	
				</select> 
				<span style='color:red;font-size:16px;'><——请选择游戏</span>
			</div> -->
			<?php } ?>
			
			<div style="padding-bottom:5px;">
			
				<img src="<?php echo $himg;?>" width="44px" height="44px" style="display: block;float:left;margin-right:10px;">
				
				<span>玩家昵称：<?php echo $name;?>(ID:<span id='uid'><?php echo $play_id;?></span>)</span><br>
				
				<span>剩余房卡：<span id='diamond'><?php echo $dimond;?></span></span>
			
			</div>
			
			<div style="padding-bottom:5px;font-size:13px;clear:both;padding-top:5px;">
				
				<span>小提示：</span><br>
				
				<span class="red">1、充值前请先确认上方的昵称和ID，是您要充值到账的账号吗？</span><br>
								
				<span class="red">2、充值前先记下您的剩余房卡数量，充值成功后立刻查看剩余房卡是否增加。</span>

			</div>
			<?php if($error_code==1){?>
			<!-- <div class="pays" style="padding-bottom:5px;">
			
				<a href="http://fhqp.tqfy0.com/tool/wxpay/example/jsapi.php?uid=<?php echo $uid;?>&tid=1&gid=2" >打赏 ¥12 可获得 12 张房卡</a>
				
				<a href="http://fhqp.tqfy0.com/tool/wxpay/example/jsapi.php?uid=<?php echo $uid;?>&tid=2&gid=2" >打赏 ¥36 可获得 36 张房卡</a>
				
				<a href="http://fhqp.tqfy0.com/tool/wxpay/example/jsapi.php?uid=<?php echo $uid;?>&tid=3&gid=2" >打赏 ¥50 可获得 50 张房卡</a>
			
			</div> -->
			<?php }else{ ?>

			<?php } ?>
			<div class="pays" style="padding-bottom:5px;"></div>
		</div>

		<div>
			
			<input type="hidden" value="<?php echo $uid;?>" id="guid">
			<input type="hidden" value="<?php echo $gid;?>" id="gid">
			<input type="hidden" value="<?php echo $auid;?>" id="auid">
		
		</div>
		
	</body>
<script>
	var gid = $('#gid').val();
 	var uid = $('#guid').val();
	var auid = $('#auid').val();
</script>	
<script src="../static/js/select_price.js"></script>
</html>