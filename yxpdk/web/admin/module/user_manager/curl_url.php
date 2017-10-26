<?php
header("Content-Type: text/html; charset=UTF-8");
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$admin_user_name = $session_data['admin_user_name'];

$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
$get_value = $db->get_one_info($get_value_sql);

$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";
$web_server = $db->get_one_info($web_server_sql);

function curl_url($web_server,$part,$data,$port){
	$uid = $data['uid'];
	//$url = $web_server.':'.$port.'/'.$part."?user_id=$uid";	
	$url = '127.0.0.1:'.$port.'/'.$part."?user_id=$uid";	
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $url);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	//打印获得的数据		
	return $output;
}

$username = $_GET['username'];

$part = $_GET['part'];

$sql = "select uid from t_game_user where uid='$username'";

$check = $db->get_one_info($sql);

if(!empty($check)){
	
	$data = array();

	$data['uid'] = $check['uid'];

	$curl_info = curl_url($web_server['setting_value'],$part,$data,$get_value['setting_value']);

	$data['action_time'] = time();
	
	$data['handler'] = $admin_user_name;
	
	$result = get_action_content($part);

	$data['content'] = $result['content'];
	
	$data['action_type'] = $result['action_type'];

	$res = $db->insert_data($data,'t_ban_log');

	$res = json_decode($curl_info,true);

	if($res['errorcode']==0){
		
		echo json_encode(1);
	
	}else{
		
		echo json_encode(0);
	
	}	

}else{
	
	echo json_encode(1);

}

function get_action_content($str){
	
	switch ($str) {
		case 'gm/kick_down':
			$content = '清除卡线';
			$action_type = 0;
			break;
		case 'gm/clear_diamond':
			$content = '房卡清零';
			$action_type = 0;
			break;
		case 'gm/ban_account':
			$content = '封号';
			$action_type = 1;
			break;
		case 'gm/dis_ban_account':
			$content = '解封';
			$action_type = 2;
			break;					
		default:
			$content = '未知';
			$action_type = 0;
			break;
	}
	
	$data = array();
	
	$data['content'] = $content;
	
	$data['action_type'] = $action_type;
	
	return $data;
}










