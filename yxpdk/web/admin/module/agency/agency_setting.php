<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//代理信息修改
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];
$first_login_time = $session_data['first_login_time'];
$uid = $agency_user_name;
$action = $_REQUEST['action'];

if ($action == 'save') {
	$nick_name = SS($_REQUEST['nick_name']);
	$phone_number = SS($_REQUEST['phone_number']);

	$sql = "update t_agency set nick_name='$nick_name', phone_number = '$phone_number'";

	$password1 = SS($_REQUEST['password1']);
	if (!empty($password1)) {
		$password2 = SS($_REQUEST['password2']);
		if ($password1 == $password2) {
			$sql .= ", password = '$password1' ";
		} else {
			infoExit("两次输入的密码不一致");
		}
	}

	if($first_login_time==0){
		$first_login_time = time();
		$session_data1 = array();
		$session_data1['first_login_time'] = $first_login_time;
		set_session($dbname, $session_data1, 7200);

		$sql .= ", first_login_time = '$first_login_time' ";
	}

	$sql .= " where uid = '$uid'";
	$res = $db->query($sql);
	if($res){
		$db->jump('修改成功！','index.php');
	}else{
		$db->jump('修改失败！','agency_setting.php');
	}
}

$sql = "select * from t_agency where uid = '$uid'";
$agency = $db->fetchOne($sql);

$smarty->assign("agency", $agency);
$smarty->display("module/agency/agency_setting.html");

