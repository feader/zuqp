<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//下级代理列表
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];
$admin_user_name = $agency_user_name;

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$sql = "select * from t_agency where uber_agency = '$admin_user_name' limit $begin,".LIST_PER_PAGE_RECORDS;

$myself = $db->fetchAll($sql);

$sqlCount    = "select count(*) as count from t_agency where uber_agency = '$admin_user_name'";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$leaguer_list = $db->fetchAll($sql);


$pageHTML    = getPages($page, $counts, LIST_PER_PAGE_RECORDS);

$smarty->assign("pageHTML", $pageHTML);
//$smarty->assign("total_cnt", $total_cnt);
$smarty->assign("leaguer_list", $leaguer_list);
$smarty->display("module/agency/agency_leaguer_list.html");

