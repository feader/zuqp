<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

$page  = getUrlParam('pid');
$begin = ($page - 1) * 20;

$where = 'where 1 ';

if(isset($_GET['dateStart']) && isset($_GET['dateEnd']) && !empty($_GET['dateStart']) && !empty($_GET['dateEnd'])){
	
	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= " and action_time between '$dateStart' and '$dateEnd'";

}

if(isset($_GET['uid']) && !empty($_GET['uid'])){

	$uid = $_GET['uid'];
	$where .= " and uids like '%$uid%'";

}

$monthbegin = strtotime(date('Y')."-".date('m')."-1");

$monthend = strtotime(date('Y')."-".date('m')."-".date('t'));

$cibeginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));

$ciendToday = $cibeginToday + 86400-1;

$cibeginyesterday = mktime(0,0,0,date('m'),date('d'),date('Y'))-86400;

$ciendyesterday = $cibeginToday-1;

$count_all_sql = 'select count(*) as all_num from t_game_room_log';

$count_month_sql = "select count(*) as month from t_game_room_log where action_time between '$monthbegin' and '$monthend'";

$count_today_sql = "select count(*) as today from t_game_room_log where action_time between '$cibeginToday' and '$ciendToday'";

$count_yesterday_sql = "select count(*) as yesterday from t_game_room_log where action_time between '$cibeginyesterday' and '$ciendyesterday'";

$all = $db->get_one_info($count_all_sql);

$month = $db->get_one_info($count_month_sql);

$today = $db->get_one_info($count_today_sql);

$yesterday = $db->get_one_info($count_yesterday_sql);

$count_data = array();

$count_data['all'] = $all['all_num'];
$count_data['month'] = $month['month'];
$count_data['today'] = $today['today'];
$count_data['yesterday'] = $yesterday['yesterday'];


$room_log_sql = "select * from t_game_room_log $where order by action_time desc limit ".$begin.',20';

$room_log_count_sql = "select count(*) as search_counts from t_game_room_log $where";
$search_counts = $db->get_one_info($room_log_count_sql);

$room_log = $db->fetchAll($room_log_sql);

$count_sql = 'select count(*) as count from t_game_room_log '.$where;
$counts      = $db->get_one_info($count_sql);
$pageHTML    = getPages($page, $counts['count'], 20);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("room_log", $room_log);
$smarty->assign("count_data", $count_data);
$smarty->assign("search_counts", $search_counts['search_counts']);
$smarty->assign("time_start", $_GET['dateStart']);
$smarty->assign("time_end", $_GET['dateEnd']);
$smarty->assign("uid", $_GET['uid']);
$smarty->display("module/game_data/room_log.html");