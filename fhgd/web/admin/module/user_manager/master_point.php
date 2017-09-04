<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);


$action = $_GET['action'];

if($action =='search_user'){
	//代理给玩家充值前的检查
	$uid = $db->check_input($_GET['uid']);

	$sql = "select username,uid from t_game_user where uid = $uid";

	$user_info = $db->get_one_info($sql);

	if(!empty($user_info)){
		
		die(json_encode($user_info));
	
	}else{
		die(json_encode(0));
	}

}else if($action =='handle'){
	//代理给玩家充值
	$username = SS($_GET['username']);
	
	$uid = SS($_GET['userid']);
	
	$username = $db->check_input($username);
	
	$uid = $db->check_input($uid);

	$sql = "select uid,dimond,sum_dimond,username from t_game_user where username = $username and uid = $uid";

	$user_info = $db->get_one_info($sql);
	
	if(!empty($user_info)){
		
		$master_point = SS($_GET['master_point']);
		
		$master_point = $db->check_input($master_point);
		
		$data2 = array();

		$data2['uid'] = $uid;
		
		$data2['add_num'] = $master_point;

		$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
		
		$get_value = $db->get_one_info($get_value_sql);

		$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";
		
		$web_server = $db->get_one_info($web_server_sql);

		$res = curl_url($web_server['setting_value'],'gm/add_point',$data2,$get_value['setting_value']);

		echo $res;die;
			
	}


	
}



function curl_url($web_server,$part,$data,$port){
	$uid = $data['uid'];
	$num = $data['add_num'];
	$url = $web_server.':'.$port.'/'.$part."?user_id=$uid&add_num=$num";
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

 
// die;




