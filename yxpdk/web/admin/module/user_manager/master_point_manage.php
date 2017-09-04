<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);



$smarty->display("module/user_manager/master_point_manage.html");