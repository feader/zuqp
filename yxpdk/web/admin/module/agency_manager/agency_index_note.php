<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db;

$note_sql = 'select * from t_system_setting where setting_name="agency_index_note"';
$note_detail = $db->get_one_info($note_sql);

if($_POST['action']=='edit'){
	$data = array();
	$data['setting_value'] = $_POST['setting_value'];
	$id = $_POST['id'];
	$res = $db->update_data($data,'t_system_setting',"id=$id");
	if($res){
		$db->jump('编辑成功！');
	}else{
		$db->jump('内容没变化或编辑失败！');
	}
	
}

$smarty->assign("note_detail", $note_detail);
$smarty->display("module/agency_manager/agency_index_note.html");
