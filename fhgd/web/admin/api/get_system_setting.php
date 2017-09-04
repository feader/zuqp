<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$note_sql = 'select * from t_system_setting where setting_name="game_notice"';
$note_detail = $db->get_one_info($note_sql);

$result = array();

$result['game_notice'] = $note_detail['setting_value'];

echo json_encode($result);
die;