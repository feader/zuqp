<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

//代理推广出来的微信用户列表
// $uid = $_SESSION['uid'];
$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];
$admin_user_name = $agency_user_name;

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$sql_wx = "SELECT * FROM `agency_to_wx_user` where uid is not null and username is not null and agency_id = '$admin_user_name' order by action_time desc limit $begin,".LIST_PER_PAGE_RECORDS;
$sql_ip = "select * from `agency_to_ip_user` where agency_id = '$admin_user_name' order by action_time DESC";

$myself_wx = $db->fetchAll($sql_wx);
$myself_ip = $db->fetchAll($sql_ip);

$mysql_all = array_merge($myself_wx,$myself_ip);

$sqlCount    = "select count(*) as count from agency_to_wx_user where uid is not null and username is not null and agency_id = '$admin_user_name'";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
// $leaguer_list = $db->fetchAll($sql);

$game_id_sql    = "select setting_value from t_system_setting where setting_name='game_id'";
$game_id = $db->get_one_info($game_id_sql);

$fx_url_sql    = "select setting_value from t_system_setting where setting_name='fx_url'";
$fx_url = $db->get_one_info($fx_url_sql);

$pageHTML    = getPages($page, $counts, LIST_PER_PAGE_RECORDS);

$smarty->assign("pageHTML", $pageHTML);
// $smarty->assign("leaguer_list", $leaguer_list);
$smarty->assign("leaguer_list", $mysql_all);
$smarty->assign("myself", $admin_user_name);
$smarty->assign("game_id", $game_id['setting_value']);
$smarty->assign("fx_url", $fx_url['setting_value']);
$smarty->display("module/agency/agency_get_wx_user_list.html");
