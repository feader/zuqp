<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;


$unionid = $_POST['unionid'];
$gamer_uid = $_POST['gamer_uid'];


$data = array();
$data['unionid'] = $unionid;
$data['fuid'] = $gamer_uid;
$data['create_time'] = time();

$check_sql = "SELECT * from `t_gamer_to_gamer` where unionid = '$unionid' and fuid = '$gamer_uid'";

$check = $db->get_one_info($check_sql);

if(!$check){
	$res = $db->insert_data($data,'t_gamer_to_gamer');
	if($res){
		$result = 1;
	}else{
		$result = 0;
	}
}else{
	$result = 0;
}

$insert_time = time();

$data1 = array();

$data1['text_conent'] = $openid.'-'.$gamer_uid.'-'.$insert_time;

$res1 = $db->insert_data($data1,'t_test_log');

echo json_encode($result);
