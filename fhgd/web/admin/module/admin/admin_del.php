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
$uid = $_GET['uid'];
if(empty($uid)){
	$db->jump('非法操作！');
}
$del = $db->delete_data('t_admin_user',"uid = '$uid'");
if($del){
	$db->jump('删除成功！','admin_list.php');
}else{
	$db->jump('删除失败！','admin_list.php');
}

