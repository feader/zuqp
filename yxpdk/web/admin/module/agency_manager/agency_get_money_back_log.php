<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db;
//代理的返现列表

if (!isset($_REQUEST['dateStart'])) {
	$t = time();
    $start_day = mktime(0,0,0,1,1,date('Y',$t)); 
    $end_day = mktime(23,59,59,date('m',$t),date('t'),date('Y',$t)); 
    $dateStart = strftime("%Y-%m", $start_day);
    $dateEnd = strftime("%Y-%m", $end_day);
} else {
    $dateStart = trim(SS($_REQUEST['dateStart']));
    $dateEnd = trim(SS($_REQUEST['dateEnd'])); 
}

$start_time = strtotime($dateStart . ' 0:0:0');
$end_time = strtotime($dateEnd . ' 0:0:0')-1;


$page  = getUrlParam('pid');
$begin = ($page - 1) * 1000;

$sql_cnt = "SELECT count(*) AS cnt FROM t_money_back_log WHERE get_money_time between $start_time and $end_time";

$result = $db->fetchOne($sql_cnt);
$total_cnt = $result['cnt'];

$sql_back_money_log = "SELECT * FROM t_money_back_log WHERE get_money_time between $start_time and $end_time ORDER BY get_money_time DESC LIMIT $begin,". 1000;
$back_money_log_list = $db->fetchAll($sql_back_money_log);

$sql_every_month_get_money_log = "SELECT * FROM t_every_month_money_back WHERE back_create_time between $start_time and $end_time ORDER BY back_date DESC LIMIT $begin,". 1000;

$every_month_get_money_log_list = $db->fetchAll($sql_every_month_get_money_log);

$pageHTML = getPages($page, $total_cnt, 1000);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("total_cnt", $total_cnt);
$smarty->assign("back_money_log_list", $back_money_log_list);
$smarty->assign("every_month_get_money_log_list", $every_month_get_money_log_list);
$smarty->display("module/agency_manager/agency_get_money_back_log.html");