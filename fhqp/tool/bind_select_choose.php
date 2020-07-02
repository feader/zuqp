<?php

$uid = $_GET['uid'];

?>
<!DOCTYPE html>
<html>
	
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		
		<link rel="stylesheet" type="text/css" href="../static/css/default.css">
		
		<script src="../static/js/jquery-2.0.0.js"></script>
		
		<script src="../static/js/fm.validator.js"></script>
		
		<title>烽火棋牌</title>
	
	</head>
	<style>
		.validator-error{color:red;}
	</style>
<body>
	
	<div style="padding:20px 10px">
		
		<div style="padding-left:5px;">如果您有代理账号请绑定账号：</div>
		
		<form method="post" action="bind_which_agency_login.php" class="validator">
		
			<input type="text" class="input" name="auid" value="" placeholder="请输入代理ID" data-required><br>
			
			<input type="password" class="input" name="password" value="" placeholder="请输入代理密码" data-required><br>
			
			<select class="select" name="gid">				
				<option value="2">烽火跑得快</option>
				<option value="3">烽火掼蛋</option>
			</select><br>
			
			<button type="submit" class="button">绑定账号</button>
			<!-- <input type="submit" class="button" value="绑定账号"> -->
			<input type="hidden" name='uid' value="<?php echo $uid;?>">
		
			<div style="padding:10px 0px 20px 5px;font-size:13px;">
			
				<span style="color:red"></span><br>
				* 如果您是未绑定的代理，您可在这里填写登录代理后台的账号和密码，将该账号绑定在使用本微信登录的代理账号上。<br>
				* 绑定后您可在公众号内进入代理后台，方便快捷的进行购卡和赠卡操作。<br>
				* 房卡代理请加官方微信：fhkf008
			
			</div>
		
		</form>

	</div>
<script>
	$(function () {
		Validator.language = 'cn';
	});
</script>
</body>

</html>