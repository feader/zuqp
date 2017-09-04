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
$where .= " AND create_time >= $start_time ";

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];
$uid = $agency_user_name;
$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$sql = "SELECT * FROM t_agency_sell_to_agency WHERE sell_agency_uid = '$uid' ".$where."ORDER BY create_time DESC LIMIT $begin, " . LIST_PER_PAGE_RECORDS;
$sql1 = "SELECT count(*) as count FROM t_agency_sell_to_agency WHERE sell_agency_uid = '$uid' ".$where;

$log_list = $db->fetchAll($sql);
$count = $db->fetchAll($sql1);
//print_r($sql);
//print_r($_SESSION);

//今天此代理给其它代理售卡数
$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
$endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
$today = get_count($beginToday,$endToday,$uid,'today',$db);

//昨天此代理给其它代理售卡数
$beginYesterday = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
$endYesterday = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
$yesterday = get_count($beginYesterday,$endYesterday,$uid,'yesterday',$db);

//上周此代理给其它代理售卡数
$beginLastweek = mktime(0,0,0,date('m'),date('d')-7,date('Y'));
$endLastweek = mktime(23,59,59,date('m'),date('d')-1,date('Y'))-1;
$lastweek = get_count($beginLastweek,$endLastweek,$uid,'lastweek',$db);

$total_data = array();
$total_data['today'] = $today;
$total_data['yesterday'] = $yesterday;
$total_data['lastweek'] = $lastweek;

$pageHTML    = getPages($page, $count['count'], LIST_PER_PAGE_RECORDS);

$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("total_cnt", $count);
$smarty->assign("total_data", $total_data);
$smarty->assign("log_list", $log_list);
$smarty->display("module/agency/agency_sell_to_agency_log.html");

function get_count($start,$end,$uid,$name,$db){
	$data = array();
	$sql = "SELECT count(*) AS $name FROM t_agency_sell_to_agency WHERE sell_agency_uid = '$uid' and create_time between $start and $end";
	$data = $db->get_one_info($sql);
	return $data[$name];
}