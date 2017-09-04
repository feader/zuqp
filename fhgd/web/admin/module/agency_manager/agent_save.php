<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;
//管理端代理信息保存
$id = $db->check_input($_POST['id']);

$check = $db->get_one_info("select * from t_agency where id = '$id'");

if(!$check){
	$db->jump('非法编辑！');
}

$data = array();
if(!empty($_POST['pwd'])){
	$data['password'] = $_POST['pwd'];
}
$data['note'] = $_POST['note'];
$data['grade'] = $_POST['grade'];
$where = "id = $id";

$res = $db->update_data($data,'t_agency',$where);

if ($res) {
	$db->jump('编辑成功！','agency_list.php');
}else{
	$db->jump('编辑失败！','agency_list.php');	
}


