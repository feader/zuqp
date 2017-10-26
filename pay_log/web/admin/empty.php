<?php
define('IN_DATANG_SYSTEM', true);
include "../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty;

$smarty->display("empty.html");