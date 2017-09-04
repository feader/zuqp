<?php
define('IN_DATANG_SYSTEM', true);
include "../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty;

if (!$auth->alreadyLogin()) { 
	
    header("Location:login.php");
    exit();
}

$smarty->display("index.html");

