<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;
//管理端代理银行信息保存
$id = $db->check_input($_POST['id']);
$uid = $db->check_input($_POST['uid']);
$sql = "select * from t_agency_bank_info where id = '$id' and uid=$uid";
$check = $db->get_one_info($sql);

if(!$check){
	$db->jump('非法编辑！');
}

$data = array();
$data['weixin'] = $_POST['weixin'];
$data['alipay'] = $_POST['alipay'];
$data['opening_bank'] = $_POST['opening_bank'];
$data['branch'] = $_POST['branch'];
$data['bank_name'] = $_POST['bank_name'];
$data['bank_account'] = $_POST['bank_account'];
$res = $db->update_data($data,'t_agency_bank_info',"id=$id");

if ($res) {
	$db->jump('编辑成功！','agency_bank_info.php');
}else{
	$db->jump('编辑失败！','agency_bank_info.php');	
}
