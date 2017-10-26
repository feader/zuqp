<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];
$uid = $agency_user_name;

$sql = "select * from t_agency where uid = '$uid'";
$agency = $db->fetchOne($sql);

$sql_notice = "select setting_value from t_system_setting where setting_name = 'agency_index_note'";
$notice = $db->fetchOne($sql_notice);

$game_id_sql    = "select setting_value from t_system_setting where setting_name='game_id'";
$game_id = $db->get_one_info($game_id_sql);

$fx_url_sql    = "select setting_value from t_system_setting where setting_name='fx_url'";
$fx_url = $db->get_one_info($fx_url_sql);

$smarty->assign("agency", $agency);
$smarty->assign("notice", $notice['setting_value']);
$smarty->assign("myself", $uid);
$smarty->assign("game_id", $game_id['setting_value']);
$smarty->assign("fx_url", $fx_url['setting_value']);
$smarty->display("module/agency/agency_main.html");

