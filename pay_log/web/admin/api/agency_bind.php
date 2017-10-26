<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";

$web_server = $db->get_one_info($web_server_sql);

$action = $_GET['action'];

if($action=='check_agency'){
	
	$unionid = $_GET['unionid'];

	$data = array();

	if($unionid!=''){
		$check_agency_sql = "select uid from t_agency where unionid='$unionid'";

		$check_agency = $db->get_one_info($check_agency_sql);

		if(!empty($check_agency)){		
			$data['code'] = 1;
			$data['name'] = '烽火跑得快';
			$data['login_url'] = $web_server['setting_value'].'/houtai/yxpdk/web/admin/module/agency/agency_login.php?action=auth_login';
		}else{
			$data['code'] = 0;
		}		
	}else{
		$data['code'] = 0;
	}
	echo json_encode($data);die;	
}

if($_POST['action']=='bind_agency_uid'){
	
	$unionid = $_POST['uid'];
	$auid = $_POST['auid'];
	$password = $_POST['password'];

	$check_agency_sql = "select uid,id,unionid from t_agency where uid='$auid' and password = '$password'";

	$check_agency = $db->get_one_info($check_agency_sql);

	$return_data = array();

	if(!$check_agency){
		$return_data['code'] = 0;
		$return_data['msg'] = '账号密码不正确';
		echo json_encode($return_data);die;
	}

	if($check_agency['unionid']==''){
		$data = array();
		$data['unionid'] = ss($unionid);
		$id = $check_agency['id'];

		$agency_update = $db->update_data($data,'t_agency',"id=$id");
		if($agency_update){
			$return_data['code'] = 1;
			$return_data['msg'] = '更新成功';
		}else{
			$return_data['code'] = 0;
			$return_data['msg'] = '更新失败';
		}		
	}else{
		$dobule_check_agency_sql = "select unionid from t_agency where uid='$auid' and password = '$password' and unionid = '$unionid'";

		$dobule_check_agency = $db->get_one_info($dobule_check_agency_sql);

		if(!empty($dobule_check_agency)){
			$return_data['code'] = 1;
			$return_data['msg'] = 'unionid已存在并与传输的一致';
		}else{
			$return_data['code'] = 0;
			$return_data['msg'] = 'unionid已存在并与传输的不一致';
		}

		
	}

	echo json_encode($return_data);die;
}

die;