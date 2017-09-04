<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db,$dbConfig;
$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$gid = $session_data['gid'];
//管理端代理编辑
if($gid>=3){
	$db->jump('此帐号没权限进行此操作！');
}
$id = $_GET['id'];
if(empty($id)){
	$db->jump('非法操作！');
}
$del = $db->delete_data('t_agency',"id = '$id'");
if($del){
	$db->jump('删除成功！','agency_list.php');
}else{
	$db->jump('删除失败！','agency_list.php');
}

