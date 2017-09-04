<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;
//代理自己的返现列表
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];

$uid = $agency_user_name;
$page  = getUrlParam('pid');
$begin = ($page - 1) * 12;

$sql_cnt = "SELECT count(*) AS cnt FROM t_money_back_log WHERE auid = '$uid'";

$result = $db->fetchOne($sql_cnt);
$total_cnt = $result['cnt'];

$sql_back_money_log = "SELECT * FROM t_money_back_log WHERE auid = '$uid' ORDER BY get_money_time DESC LIMIT $begin,". 12;
$back_money_log_list = $db->fetchAll($sql_back_money_log);

$sql_every_month_get_money_log = "SELECT * FROM t_every_month_money_back WHERE auid = '$uid' ORDER BY back_date DESC LIMIT $begin,". 12;
$every_month_get_money_log_list = $db->fetchAll($sql_every_month_get_money_log);

$pageHTML    = getPages($page, $total_cnt, 12);


$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("total_cnt", $total_cnt);
$smarty->assign("back_money_log_list", $back_money_log_list);
$smarty->assign("every_month_get_money_log_list", $every_month_get_money_log_list);
$smarty->display("module/agency/agency_get_money_back.html");