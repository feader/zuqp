<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$adimn_gid = $session_data['gid'];

//编辑管理员信息
$uid = $db->check_input($_GET['uid']);

$sql = "select * from t_admin_user where uid = $uid";
$check = $db->get_one_info($sql);

$group_sql = "select * from t_group";
$group_info = $db->fetchAll($group_sql);


if(!$check){
	$db->jump('非法操作！');
}

$smarty->assign("detail", $check);
$smarty->assign("group_info", $group_info);
$smarty->assign("adimn_gid", $adimn_gid);
$smarty->display("module/admin/admin_edit.html");

?>