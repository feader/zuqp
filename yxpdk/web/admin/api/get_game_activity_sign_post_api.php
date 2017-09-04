<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$unionid = $_POST['unionid'];

$check_sql = "select id,sign,sign_sort from t_offline_play where unionid='$unionid'";

$check = $db->get_one_info($check_sql);

$result = array();

if(!$check){
	$result['code'] = 0;
	$result['msg'] = "<p class='center'>你没报名！</p>";
	
	echo json_encode($result);die;

}

if($check['sign']==0){
	$sign_time = time();
	$insert_data = array();
	$insert_data['unionid'] = $unionid;
	$insert_data['sign_time'] = $sign_time;
	$insert_res = $db->insert_data($insert_data,'t_offlineplay_sign_sort');
	
	$id = $check['id'];
	$data = array();
	$data['unionid'] = $unionid;
	$data['sign'] = 1;
	$data['sign_time'] = $sign_time;
	$data['sign_sort'] = $insert_res;

	$res = $db->update_data($data,'t_offline_play',"id=$id");
	
	if($res){
		$result['code'] = 1;
		$result['msg'] = "<p class='center'>签到成功！</p><p class='center'>序号：$insert_res</p><p class='center'>请把序号报给工作人员完成签到登记！</p>";
	}else{
		$result['code'] = 0;
		$result['msg'] = "<p class='center'>签到失败！</p>";
	}

}else{
		
	$sort = $check['sign_sort'];
	$result['code'] = 0;
	$result['msg'] = "<p class='center'>你已签到，请不要重复签到！</p><p class='center'>序号：$sort</p><p class='center'>请把序号报给工作人员完成签到登记！</p>";

}


echo json_encode($result);





















die;