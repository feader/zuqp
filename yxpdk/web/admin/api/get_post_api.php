<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;


$unionid = $_POST['unionid'];
$agency_uid = $_POST['agency_uid'];
$agent_ip = $_POST['agent_ip'];

$data = array();
$data['unionid'] = $unionid;
$data['agency_id'] = $agency_uid;
$data['agent_ip'] = $agent_ip;
$data['action_time'] = time();

if(isset($agent_ip) && !empty($agent_ip)){
	$check_sql = "SELECT * from `t_agency_and_user` where agent_ip = '$agent_ip' and agency_id = '$agency_uid'";
}else{
	$check_sql = "SELECT * from `t_agency_and_user` where unionid = '$unionid' and agency_id = '$agency_uid'";
}



$check = $db->get_one_info($check_sql);

if(!$check){
	$res = $db->insert_data($data,'t_agency_and_user');
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

$data1['text_conent'] = $data.'-'.$insert_time;

$res1 = $db->insert_data($data1,'t_test_log');
var_dump($res1);

echo json_encode($result);

