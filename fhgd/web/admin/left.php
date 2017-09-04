<?php
define('IN_DATANG_SYSTEM', true);
include "../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$gid = $session_data['gid'];

$user_power = $auth->getUserPower($buf_lang);

$smarty->assign("user_power", $user_power);
$smarty->assign("gid", $gid);
$smarty->display("left.html");