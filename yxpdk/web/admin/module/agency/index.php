<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty , $db,$dbConfig;

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$first_login_time = $session_data['first_login_time'];

if (!$auth->agencyalreadyLogin()) { 
    header("Location:agency_login.php");
    exit();
}

if($first_login_time==0){
	$db->jump('系统检测您还没修改过密码，请立刻修改密码！','agency_setting.php');
}

$smarty->display("module/agency/index.html");