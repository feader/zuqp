<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//代理出售列表
if (!isset($_REQUEST['dateStart'])) {
    $start_day = GetTime_Today0();
    $dateStart = strftime("%Y-%m-%d", $start_day);
    $dateEnd = strftime("%Y-%m-%d", $start_day+ 86400);
} else {
    $dateStart = trim(SS($_REQUEST['dateStart']));
}

$start_time = strtotime($dateStart . ' 0:0:0');
// $end_time = $start_time + 86400;

//$where .= " AND action_time >= $start_time AND action_time <= $end_time ";
$where .= " AND action_time >= $start_time ";

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];
$uid = $agency_user_name;
$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$sql_cnt = "SELECT count(*) AS cnt FROM t_sell_log WHERE seller_uid = '$uid'" . $where;

$search_sql = "SELECT sum(dimond_num) AS search_total FROM t_sell_log WHERE seller_uid = '$uid'" . $where;
$search = $db->fetchOne($search_sql);

$result = $db->fetchOne($sql_cnt);
$total_cnt = $result['cnt'];
// echo $total_cnt;

$sql = "SELECT buyer_uid,dimond_num,dimond_num,action_time,buyer_name FROM t_sell_log WHERE seller_uid = '$uid' ".$where."ORDER BY action_time DESC LIMIT $begin, " . LIST_PER_PAGE_RECORDS;
$log_list = $db->fetchAll($sql);
//print_r($sql);
//print_r($_SESSION);

//今天此代理给玩家售卡数
$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
$endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
$today = get_count($beginToday,$endToday,$uid,'today',$db);

//昨天此代理给玩家售卡数
$beginYesterday = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
$endYesterday = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
$yesterday = get_count($beginYesterday,$endYesterday,$uid,'yesterday',$db);

//上周此代理给玩家售卡数
$beginLastweek = mktime(0,0,0,date('m'),date('d')-7,date('Y'));
$endLastweek = mktime(23,59,59,date('m'),date('d')-1,date('Y'))-1;
$lastweek = get_count($beginLastweek,$endLastweek,$uid,'lastweek',$db);

//此代理给玩家全部售卡数
$all_sell = get_count(0,$endToday,$uid,'all_sell',$db);

$total_data = array();
$total_data['today'] = $today ? $today : 0;
$total_data['yesterday'] = $yesterday ? $yesterday : 0;
$total_data['lastweek'] = $lastweek ? $lastweek : 0;
$total_data['all'] = $all_sell ? $all_sell : 0;

$pageHTML = getPages($page, $total_cnt, LIST_PER_PAGE_RECORDS);

$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("total_cnt", $total_cnt);
$smarty->assign("total_data", $total_data);
$smarty->assign("log_list", $log_list);
$smarty->assign("search", $search);
$smarty->display("module/agency/agency_sell_log.html");

function get_count($start,$end,$uid,$name,$db){
	$data = array();
	$sql = "SELECT sum(dimond_num) AS $name FROM t_sell_log WHERE seller_uid = '$uid' and action_time between $start and $end";
	$data = $db->get_one_info($sql);
	return $data[$name];
}