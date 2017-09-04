<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;
 	
//新增管理员	
$data = array();

$data['username'] = $_POST['username'];

$data['passwd'] = md5($_POST['pwd']);

$data['gid'] = $_POST['gid'];

$data['agent_id'] = $_POST['agent_id'];

//查找用户组信息
$sql1 = "select remark from t_group where gid = {$_POST['gid']}";

$remark = $db->get_one_info($sql1);

$data['admin_desc'] = $remark['remark'];

$check = $db->get_one_info("select * from t_admin_user where username = '{$_POST['username']}'");
if(!empty($check['username']) && $check['username']!='' ){
	$db->jump('用户名已存在！');
}

$res = $db->insert_data($data,'t_admin_user');

if ($res) {
	$db->jump('新增成功！','admin_list.php');
}else{
	$db->jump('新增失败！','admin_list.php');	
}	

	
