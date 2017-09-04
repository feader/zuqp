<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$ip = $_GET['ip'];

$uid = $_GET['uid'];

$check_sql = "select reg_ip from t_game_user where uid=$uid";

$check = $db->get_one_info($check_sql);

if($check['reg_ip']==null){

	$data = array();

	$data['reg_ip'] = $ip;

	$where = "uid = '$uid'";

	//$res = $db->update_data($data,'t_game_user',$where);

	echo json_encode(1);

}else{

	echo json_encode(0);

}



