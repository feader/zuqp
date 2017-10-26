<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db,$dbConfig;
$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$gid = $session_data['gid'];
//管理端代理编辑
$id = $_GET['id'];

$sql = "select * from t_agency where id = $id";
$agency_detail = $db->query($sql);
$detail = $db->getOne($agency_detail);

$sql_notice = "select setting_value from t_system_setting where setting_name = 'agency_index_note'";
$notice = $db->fetchOne($sql_notice);

$game_id_sql    = "select setting_value from t_system_setting where setting_name='game_id'";
$game_id = $db->get_one_info($game_id_sql);

$fx_url_sql    = "select setting_value from t_system_setting where setting_name='fx_url'";
$fx_url = $db->get_one_info($fx_url_sql);

$smarty->assign("detail", $detail);
$smarty->assign("agency_uid", $detail['uid']);
$smarty->assign("notice", $notice['setting_value']);
$smarty->assign("game_id", $game_id['setting_value']);
$smarty->assign("fx_url", $fx_url['setting_value']);
$smarty->assign("gid", $gid);

$smarty->display("module/agency_manager/agency_edit.html");

