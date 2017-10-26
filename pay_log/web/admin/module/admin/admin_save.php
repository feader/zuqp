<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

//新增管理员的写入
$data = array();

$uid = $_POST['uid'];

$gid = $_POST['gid'];

if(!empty($_POST['pwd']) && $_POST['pwd']!=''){

	$data['passwd'] = md5($_POST['pwd']);	

}

$data['gid'] = $gid;

$where = "uid='$uid'";

$res = $db->update_data($data,'t_admin_user',$where);


if ($res) {

	$db->jump('编辑成功！','admin_list.php');

}else{

	$db->jump('编辑失败！','admin_list.php');	

}

