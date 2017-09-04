<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$oid = $_GET['uid'];

$user_sql = "select uid,dimond from t_game_user where unionid='$oid'";

$user_info = $db->get_one_info($user_sql);

if($_GET['uinfo']){

	echo $_GET['uinfo']."(".json_encode($user_info).")";die;

}

echo json_encode($user_info);

die;