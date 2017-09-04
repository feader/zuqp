<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty,$dbConfig;

// session_destroy();
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
clear_session($dbname);
// session_destroy();
// unset($_SESSION);
echo "<script>top.location.href='./agency_login.php';</script>";

