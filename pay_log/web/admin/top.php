<?php
define('IN_DATANG_SYSTEM', true);
include "../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$username = $session_data['admin_user_name'];

$smarty->assign("username", $username);
$smarty->display("top.html");