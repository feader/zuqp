<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//代理信息修改
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$uid = $session_data['agency_user_name'];
$action = $_REQUEST['action'];

if ($action == 'save') {
	$data = array();
	$data['weixin'] = SS($_REQUEST['weixin']);
	$data['alipay'] = SS($_REQUEST['alipay']);
	$data['opening_bank'] = SS($_REQUEST['opening_bank']);
	$data['branch'] = SS($_REQUEST['branch']);
	$data['bank_name'] = SS($_REQUEST['bank_name']);
	$data['bank_account'] = SS($_REQUEST['bank_account']);

	$check_sql = "select * from t_agency_bank_info where uid = '$uid'";

	$check = $db->get_one_info($check_sql);
	
	if($check){
		$res = $db->update_data($data,'t_agency_bank_info',"uid='$uid'");
	}else{		
		$data['uid'] = $uid;
		$res = $db->insert_data($data,'t_agency_bank_info');		
	}

	if($res){
		$db->jump('修改成功！');
	}else{
		$db->jump('修改出错！');
	}
}

$sql = "select * from t_agency_bank_info where uid = '$uid'";
$agency = $db->fetchOne($sql);


$smarty->assign("agency", $agency);
$smarty->display("module/agency/agency_bank_info.html");

