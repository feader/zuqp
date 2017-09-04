<?php
include SYSDIR_ADMIN."/include/functions.php";
include SYSDIR_ADMIN."/class/mem.class.php";

global $mem , $memConfig;
$mem = new memClass();
$mem->connect($memConfig);

//获取serverid->合服分组key
function get_server_keys(){
	global $mem;
	if($all = $mem->get("servers_key"))
		return $all;
	init_from_db();
	return $mem->get("servers_key");
}
//获取整个存储数据结构
function get_all_server(){
	global $mem;
	if($all = $mem->get("all_server"))
		return $all;
	init_from_db();
	return $mem->get("all_server");
}

function set_all_server($all){
	global $mem;
	$mem->set("all_server",$all);
}

//获取合服分组
function get_servers(){
	global $mem;
	if($all = $mem->get("servers"))
		return $all;
	init_from_db();
	return $mem->get("servers");
}

function init_from_db(){
	include SYSDIR_ADMIN.'/include/api_global.php';
	global $db,$mem;
	$sql = "select * from db_server_state ";
	$result = $db->fetchAll($sql);
	$data = array();
	$mergerKey = array();
	foreach($result as $v){
		$tmpArr = array();
		$tmpArr['online'] = 0;
		$tmpArr['name'] = $v['name'];
		$tmpArr['state'] = 1;
		$tmpArr['server_id'] = $v['server_id'];
		if($v['merger_key']> 0){
			
		}
	}
	
}
?>
