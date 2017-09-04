<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

//$monthstart = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
//$monthend = date('Y-m-d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));

//钻石消耗日志

if($_GET['action']=='search'){
	
	$post = array();	
	
	foreach ($_GET as $key => $value) {
		
		$post[$key] = $db->check_input($value);
	
	}
	
	switch ($post['sort']) {
		case '1':
			$order = 'order by write_time desc';
			break;
		case '2':
			$order = 'order by write_time asc';
			break;
		case '3':
			$order = 'order by everyday_total_use desc';
			break;
		case '4':
			$order = 'order by everyday_total_use asc';
			break;
		
		default:
			$order = '';
			break;
	}
	
	$start = strtotime(str_replace("'","",$post['dateStart']));
	$end = strtotime(str_replace("'","",$post['dateEnd']));
		
	$sql = "select * from t_everyday_user_dimond_log where write_time between '$start' and '$end' $order limit 0,365";
	// $sqlCount    = "select count(1) as count from t_user_dimond_log";
	// $resultCount = $db->fetchOne($sqlCount);
	// $counts      = $resultCount['count'];
	$dimond_log_list = $db->fetchAll($sql);	

	foreach ($dimond_log_list as $key => $value) {
		$total += $value['everyday_total_use'];
	}

	$smarty->assign("dimond_log_list", $dimond_log_list);
	$date_time = array();
    $date_time['start'] = date('Y-m-d', $start);
    $date_time['end'] = date('Y-m-d', $end);
	$smarty->assign("date_time", $date_time);

}

$all_cost_sql = "select sum(everyday_total_use) as all_cost from t_everyday_user_dimond_log";
$all_cost = $db->get_one_info($all_cost_sql);	

$smarty->assign("total", $total);
$smarty->assign("all_cost", $all_cost['all_cost']);

$smarty->display("module/game_manager/dimond_log_list.html");