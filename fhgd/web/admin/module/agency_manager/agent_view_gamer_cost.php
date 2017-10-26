<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

$page  = getUrlParam('pid');
$begin = ($page - 1) * 100;

$uid = $_GET['id'];

$sql = "select * from t_agency_and_user where agency_id = '$uid'";
$agency_invite_user = $db->fetchAll($sql);

$view_ids = array();

if(!empty($agency_invite_user)){

	foreach ($agency_invite_user as $k => $v) {
		$unionid = $v['unionid'];
		$every_sql = "select uid from t_game_user where unionid = '$unionid'";
		$every_info = $db->get_one_info($every_sql);
		$view_ids['ids'] .= $every_info['uid'].',';		
	}

	$view_ids = trim($view_ids['ids'],',');

	$str = 'in(';

	$str .= $view_ids;

	$str .= ')';

}else{
	
	$str = "in('')";

}


$cost_sql = "select * from t_user_dimond_log where uid $str order by use_time LIMIT $begin, " . 100;
$agency_invite_user_cost1 = $db->fetchAll($cost_sql);


$where = 'where 1';

$date_time = array();

$where .= " and uid $str";
	
if($_GET['dateStart']){
	if(!empty($agency_invite_user_cost1)){
		
		$start = strtotime($_GET['dateStart']);
		
		$where .= " and use_time >= '$start'";

		$date_time['datestart'] = date('Y-m-d', $start);
		
	}else{

		$start = strtotime($_GET['dateStart']);

		$date_time['datestart'] = date('Y-m-d', $start);

	}	
	
}else{
	$date_time['datestart'] = '';
}

if($_GET['dateEnd']){
	if(!empty($agency_invite_user_cost)){

		$end = strtotime($_GET['dateEnd']);				
		
		$where .= " and use_time <= '$end'";

		$date_time['dateend'] = date('Y-m-d', $end);

	}else{

		$end = strtotime($_GET['dateEnd']);		

		$date_time['dateend'] = date('Y-m-d', $end);

	}
	
}else{
	$date_time['dateend'] = '';
}

$cost_sql = "select * from t_user_dimond_log $where order by use_time LIMIT $begin, " . 100;
$agency_invite_user_cost = $db->fetchAll($cost_sql);

$sqlCount = "select count(*) as count from t_user_dimond_log where uid $str";

$search_sum_sql = $cost_sql = "select sum(use_dimond) as total_diamond from t_user_dimond_log $where";
$search_sum = $db->get_one_info($search_sum_sql);

$smarty->assign("date_time", $date_time);

$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 100);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("agency_invite_user_cost", $agency_invite_user_cost);
$smarty->assign("uid", $uid);
$smarty->assign("search_sum", $search_sum['total_diamond']);
$smarty->display("module/agency_manager/agency_view_gamer_cost.html");
