<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$where = 'where 1 ';

if(isset($_GET['dateStart']) && isset($_GET['dateEnd'])){
	
	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	if($dateStart!='' && $dateEnd!=''){
		$where .= "and create_time between '$dateStart' and '$dateEnd'";
	}
	
	$data_count_sql = "select * from t_data_count $where order by data_time desc limit ".$begin.','.LIST_PER_PAGE_RECORDS;

}else{
	
	$data_count_sql = "select * from t_data_count order by data_time desc limit ".$begin.','.LIST_PER_PAGE_RECORDS;
	
}

$data_count = $db->fetchAll($data_count_sql);

$count_sql = 'select count(*) as count from t_data_count '.$where;

$counts      = $db->get_one_info($count_sql);
$pageHTML    = getPages($page, $counts['count'], LIST_PER_PAGE_RECORDS);

$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));

$endToday = $beginToday+86400-1;

$acu_sql = "select sum(online) as online_num from t_online_log where dateline between $beginToday and $endToday";

$now_time = time();

//日平均在线人数
$acu = $db->get_one_info($acu_sql);
$aacu_res = number_format($acu['online_num']/(($now_time-$beginToday)/60),1,".","");

$data_date = date('Y-m-d',$beginToday);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("data_count", $data_count);
$smarty->assign("time_start", $_GET['dateStart']);
$smarty->assign("time_end", $_GET['dateEnd']);
$smarty->assign("today_avg_online_num", $aacu_res);
$smarty->assign("data_date", $data_date);
$smarty->display("module/game_data/data_count_list.html");