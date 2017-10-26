<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;
//代理信息修改

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$gid = $session_data['gid'];

$sql = "select * from t_system_setting where id not in(1,10)";
$setting_info = $db->fetchAll($sql);

$smarty->assign("setting_info", $setting_info);
$smarty->assign("gid", $gid);
$smarty->display("module/admin/set_values.html");

