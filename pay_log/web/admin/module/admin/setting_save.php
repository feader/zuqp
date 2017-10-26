<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;

$action = $_GET['action'];

if($action == 'save_info'){
	$id = $_POST['id'];
	$data = array();
	$data['setting_value'] = $_POST['setting_value'];
	$res = $db->update_data($data,'t_system_setting',"id=$id");
	$back = array();
	if($res){
		$back['rcode'] = 1;
	}else{
		$back['rcode'] = 0;
		$back['msg'] = '数值没变化/修改失败！';
	}
	echo json_encode($back);die;
}




