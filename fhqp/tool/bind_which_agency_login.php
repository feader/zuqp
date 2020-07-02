<?php
include_once 'config/config.php';

$auid = $_POST['auid'];
$password = $_POST['password'];
$uid = $_POST['uid'];
$gid = $_POST['gid'];

if(!isset($auid)||!isset($password)||!isset($uid)||!isset($gid)){
	echo "<h2>参数错误，请重新绑定！</h2>";die;
}

$common = new config();

$url = $common->bind_login_url($gid);

$post_data = array();
$post_data['auid'] = $auid;
$post_data['password'] = $password;
$post_data['uid'] = $uid;
$post_data['action'] = 'bind_agency_uid';

$post_res = $common->curl_post($url,$post_data);

$back_res = json_decode($post_res,true);

if($back_res['code']==1){
	// echo $post_res['msg'];
	$jump_url = $common->auth_login_url($gid);

	$jump_url = $jump_url.'&uid='.$uid;

	header("Location:$jump_url");

}else{

	echo "<h2>绑定的账号密码不对，请重新绑定！</h2>";die;

}




