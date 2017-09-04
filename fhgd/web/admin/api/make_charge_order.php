<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$trade_no = $_POST['trade_no'];

$price = $_POST['price'];

$num = $_POST['num'];

$unionid = $_POST['uid'];

$check_sql = "select uid from t_game_user where unionid='$unionid'";

$check = $db->get_one_info($check_sql);

if($check){

	$data = array();

	$data['trade_no'] = $trade_no;
	
	$data['price'] = $price;
	
	$data['dimond'] = $num;
		
	$data['uid'] = $check['uid'];

	$rand_str = generate_password(9);
	
	$data['order_sn'] = $rand_str.time();

	$data['create_time'] = time();

	$res = $db->insert_data($data,'t_user_charge_order');

	echo json_encode(1);die;

}else{

	echo json_encode(0);die;

}


function generate_password($length=4){ 
// 密码字符集，可任意添加你需要的字符 
	$chars = '123456789abcdefghijklmnpqrstuvwxyz'; 
	$password =''; 
	for ( $i = 0; $i < $length; $i++ ) { 
		// 这里提供两种字符获取方式 
		// 第一种是使用 substr 截取$chars中的任意一位字符； 
		// 第二种是取字符数组 $chars 的任意元素 
		// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
		$password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
	} 
	return $password; 
} 
die;