<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db,$dbConfig;
$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
//管理端代理房卡调整

if($_POST['action']=='change'){

	if($_POST['diamond']<0){

		$db->jump('房卡数不能输入负数！');
	
	}

	$auid = $_POST['auid'];

	$check_sql = "select uid,recharge_dimond from t_agency where uid='$auid'";

	$check = $db->get_one_info($check_sql);

	if(!$check){

		$db->jump('代理账号不存在！');
	
	}

	$diamond = '';
	
	if($_POST['change_type']==1){
		
		$diamond = $_POST['diamond'];
		
		$recharge_dimond = $check['recharge_dimond'] + $_POST['diamond'];
	
	}else if($_POST['change_type']==2){
		
		$diamond = '-'.$_POST['diamond'];

		$recharge_dimond = $check['recharge_dimond'] - $_POST['diamond'];

		if($recharge_dimond<0){

			$db->jump('代理账号房卡不够扣！');

		}
	
	}

	$data = array(
		'auid' => $auid,
		'diamond' => $diamond,
		'handler' => $session_data['admin_user_name'],
		'create_time' => time(),
		'note' => $_POST['note'],
	);

	$data1 = array(
		'uid' => $auid,
		'recharge_dimond' => $recharge_dimond,
	);	

	$update_res = $db->update_data($data1,'t_agency',"uid = '$auid'");

	$insert_res = $db->insert_data($data,'t_agency_diamond_change_log');

	if($update_res && $insert_res){

		$db->jump('操作完成！');
	
	}else{

		$db->jump('操作出错！');
	
	}

}

$smarty->assign("detail", $detail);
$smarty->display("module/agency_manager/agency_diamond_change.html");