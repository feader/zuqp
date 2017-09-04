<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;
//管理员列表
$page  = getUrlParam('pid');
$begin = ($page - 1) * 100;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$username = $session_data['admin_user_name'];

$sql = "select * from t_admin_user where username = '$username'";
$get_admin_info = $db->query($sql);
$admin_info = $db->getone($sql);
$gid = $admin_info['gid'];

switch ($gid) {
	case 1:
		$uid = $admin_info['uid'];
		$sql1 = "select * from t_admin_user where uid!='$uid'";
		break;
	case 2:
		$sql1 = "select * from t_admin_user where gid >= 3";
		break;
	default:	
		$sql1 = '';	
		break;
}
$list = array();
$list[0] = $admin_info;
$admin_list = $db->fetchAll($sql1);
$admin_list = array_merge($list, $admin_list);

$counts      = count($admin_list);
$pageHTML    = getPages($page, $counts, 100);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("gid", $gid);
$smarty->assign("myself_name", $username);
$smarty->assign("admin_list", $admin_list);
$smarty->display("module/admin/admin_list.html");
