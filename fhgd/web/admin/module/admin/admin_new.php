<?php

define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;

//新增管理员页面
$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$gid = $session_data['gid'];

$sql_group = 'select gid,name from t_group order by gid asc';
$result_group = $db->fetchAll($sql_group);

$smarty->assign("result_group", $result_group);

$smarty->display("module/admin/admin_new.html");



