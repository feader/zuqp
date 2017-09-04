<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//代理的充值列表
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$admin_user_name = $session_data['agency_user_name'];

$uid = $_GET['uid'];

$sql = "select uid,grade,uber_agency,nick_name,recharge_dimond from t_agency where uber_agency = '$admin_user_name' and uid='$uid'";

$check = $db->get_one_info($sql);

if(!$check){
	//$db->jump('非法信息！');
}

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$sql1 = "select * from t_recharge_log where uid = '$uid' and order_status = 1 limit $begin,".LIST_PER_PAGE_RECORDS;

$charge_log_list = $db->fetchAll($sql1);

$sql2 = "select sum(dimond_number) as total_dimond,sum(money_number) as total_money from t_recharge_log where uid = '$uid' and order_status = 1";
$total = $db->get_one_info($sql2);


// $sqlCount    = "select count(1) as count from t_recharge_log";
// $resultCount = $db->fetchOne($sqlCount);
$counts      = count($charge_log_list);
$pageHTML    = getPages($page, $counts, LIST_PER_PAGE_RECORDS);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("charge_log_list", $charge_log_list);
$smarty->assign("agency_info", $check);
$smarty->assign("total_charge", $total);
$smarty->display("module/agency/agency_charge_list.html");