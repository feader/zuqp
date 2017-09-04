<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];

//代理自己的返卡列表
if (!isset($_REQUEST['dateStart'])) {
    $start_day = GetTime_Today0();
    $dateStart = strftime("%Y-%m-%d", $start_day);
    $dateEnd = strftime("%Y-%m-%d", $start_day+ 86400);
} else {
    $dateStart = trim(SS($_REQUEST['dateStart']));
    $dateEnd = trim(SS($_REQUEST['dateEnd']));
}

$start_time = strtotime($dateStart . ' 0:0:0');
$end_time = strtotime($dateEnd . ' 0:0:0')-1;

$where .= " AND create_time between $start_time and $end_time";

$uid = $agency_user_name;
$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$sql_cnt = "SELECT count(*) AS cnt FROM t_agency_get_dimond_back_log WHERE auid = '$uid'".$where;

$result = $db->fetchOne($sql_cnt);
$total_cnt = $result['cnt'];

$sql = "SELECT * FROM t_agency_get_dimond_back_log WHERE auid = '$uid' $where ORDER BY create_time DESC LIMIT $begin,". LIST_PER_PAGE_RECORDS;
$log_list = $db->fetchAll($sql);

$pageHTML    = getPages($page, $total_cnt, LIST_PER_PAGE_RECORDS);

$smarty->assign("dateStart", $dateStart);
$smarty->assign("dateEnd", $dateEnd);
$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("total_cnt", $total_cnt);
$smarty->assign("log_list", $log_list);
$smarty->display("module/agency/agency_get_dimond_back.html");
