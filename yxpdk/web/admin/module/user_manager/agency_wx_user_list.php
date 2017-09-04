<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;

//代理推广出来的微信用户列表
// $uid = $_SESSION['uid'];
// $admin_user_name = $_SESSION['agency_user_name'];

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$where = 'where 1 ';
$search = array();

if(isset($_GET['agency_id']) && !empty($_GET['agency_id'])){
	$agency_id = $_GET['agency_id'];
	$where .= "and agency_id = '$agency_id' ";
	$search['agency_id'] = $agency_id;

	$sql_wx = "SELECT * FROM `agency_to_wx_user` where uid is not null and username is not null and agency_id = '$agency_id' order by action_time desc limit $begin,".LIST_PER_PAGE_RECORDS;
	$sql_ip = "select * FROM `agency_to_ip_user` $where order by action_time DESC limit $begin,".LIST_PER_PAGE_RECORDS;

}else{
	
	$sql_wx = "SELECT * FROM `agency_to_wx_user` where uid is not null and username is not null order by action_time desc limit $begin,".LIST_PER_PAGE_RECORDS;
	$sql_ip = "select * FROM `agency_to_ip_user` order by action_time DESC limit $begin,".LIST_PER_PAGE_RECORDS;

}

$myself_wx = $db->fetchAll($sql_wx);
$myself_ip = $db->fetchAll($sql_ip);

$myself = array_merge($myself_wx,$myself_ip);

$sqlCount    = "select count(*) as count from agency_to_wx_user $where";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$leaguer_list = $db->fetchAll($sql_wx);


$pageHTML    = getPages($page, $counts, LIST_PER_PAGE_RECORDS);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("leaguer_list", $myself);
$smarty->assign("search", $search);
$smarty->display("module/user_manager/all_wx_user_list.html");
