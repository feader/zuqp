<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//代理自己充值记录
$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];


$sql = "select order_id,order_status,uid,dimond_number,money_number,create_time,pay_way from t_recharge_log where uid = '$agency_user_name' order by create_time desc LIMIT $begin,".LIST_PER_PAGE_RECORDS;
$agency_charge_list = $db->fetchAll($sql);
$sql1 = "select count(*) as count from t_recharge_log where uid = '$agency_user_name'";
$count = $db->get_one_info($sql1);

//$counts      = count($agency_charge_list);
$pageHTML    = getPages($page, $count['count'], LIST_PER_PAGE_RECORDS);

$smarty->assign("agency_charge_list", $agency_charge_list);
$smarty->assign("pageHTML", $pageHTML);
$smarty->display("module/agency/agency_recharge_log.html");

