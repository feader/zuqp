<?php

$rid = $_GET['rid'];

$gid = $_GET['gid'];

include_once 'config.php';

$common = new config();

$down_url = $common->down_game_url($gid);

$android_location_url = $common->android_location_url($gid,$rid);

$ios_location_url = $common->ios_location_url($gid,$rid);

$icon_url = $common->icon_img_url($gid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<script src="../static/js/jquery-2.0.0.js"></script>
	<title>烽火棋牌</title>
	<style>
		#opacity {
			width:100%;
			height:100%;
			opacity:0.6;
			filter:alpha(opacity=60);
			background-color:#000;
			position:absolute;
			top:0;
			left:0;
			display:none;
			z-index:3;
		}
		.dowload {
			position:absolute;
			left:50%;
			transform:translate(-50%,0);
			-webkit-transform:translate(-50%,0);
			-moz-transform:translate(-50%,0);
			bottom:15%;
		}
		#downloadTip {
			width:320px;
			height:82px;
			top:30px;
			display:none;
			z-index:4;
			position:absolute;
			left:50%;
			transform:translate(-50%,0);
			-webkit-transform:translate(-50%,0);
			-moz-transform:translate(-50%,0);
		}
		.icon {
			position:absolute;
			left:50%;
			transform:translate(-50%,0);
			-webkit-transform:translate(-50%,0);
			-moz-transform:translate(-50%,0);
			top:20%;
			text-align:center;
			width: 180px;
			height: 180px;
		}
		.icon img{
			width: 180px;
			height: 180px;
		}
	</style>
</head>
<body>
	<div id="opacity" style="display: none;"></div>
	<div id="downloadTip" style="display: none;"><img src="../static/img/tip.png"></div>
	<div class="icon">
      <img src="<?php echo $icon_url;?>">
    </div>
	<div class="dowload">
      	<a id="btn" href="#">
        	<img id="btnImg" src="../static/img/open_btn.png" style="height: 50px;">
        </a>
    </div>
	<script language="javascript">

 	var ua = navigator.userAgent.toLowerCase();

 	var isWX = ua.match(/micromessenger/i) == "micromessenger";

 	var showTip = isWX;

 	if (showTip) {

    	opacity.style.display = 'block';   

    	downloadTip.style.display = 'block'; 	

  	} else {

    	opacity.style.display = 'none';

    	downloadTip.style.display = 'none'; 	

  	}
 	
 	var down_url = "<?php echo $down_url;?>";
	
    function open_or_download_app() {

        if (ua.match(/(iphone|ipod|ipad)/i)) {
　　　　　　var location_url = "<?php echo $ios_location_url;?>";           
            window.location.href = location_url;
          	setTimeout(function() {
	            window.location.href = down_url;
	        },2000);

        }else if(ua.match(/android/i)) {
　　　　　　var location_url = "<?php echo $android_location_url;?>";
			window.location.href = location_url;
          	setTimeout(function() {
	            window.location.href = down_url;
	        },2000);

　　　　} 
　　} 

	btn.onclick = open_or_download_app;

	</script>	　
	
</body>
</html>