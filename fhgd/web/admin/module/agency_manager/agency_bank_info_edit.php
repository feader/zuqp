<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;
//管理端代理编辑
$id = $_GET['id'];

$sql = "select * from t_agency_bank_info where id = $id";
$agency_detail = $db->query($sql);
$detail = $db->getOne($agency_detail);

$smarty->assign("detail", $detail);
$smarty->display("module/agency_manager/agency_bank_info_edit.html");

