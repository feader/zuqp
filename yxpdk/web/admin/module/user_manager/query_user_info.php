<?php
header("Content-Type: text/html; charset=UTF-8");
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$uid = $session_data['uid'];

//查询玩家信息
if (!empty($uid) && $_GET['action']=='query') {
	
	$uid = $db->check_input($_GET['username']);
	
	$res = $db->get_one_info("select * from t_game_user where uid='$uid'");

	if ($res) {
		$user = array('uid' => $res['uid'],
		'username' => $res['username'],
		'register_time' => $res['register_time'],
		'last_login_time' => $res['last_login_time'],
		'last_dimond_charge_time' => $res['last_dimond_charge_time'],
		'dimond' => $res['dimond'],
		'sum_dimond' => $res['sum_dimond'],
		);
		$smarty->assign("user", $user);
	}else{
		$db->jump('没有该用户信息！');
	}
	
	
}

$smarty->display("module/user_manager/query_user_info.html");