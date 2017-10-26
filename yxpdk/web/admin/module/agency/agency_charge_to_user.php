<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$agency_user_name = $session_data['agency_user_name'];

$action = $_GET['action'];

$result = array();

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

	$dimond_number = SS($_GET['dimond_number']);

	$dimond_number = $db->check_input($dimond_number);

	//更新出售钻石的代理的信息
	$data2 = array();

	$charge_acengy = $agency_user_name;

	$sql1 = "select uid,recharge_dimond from t_agency where uid = '$charge_acengy'";

	$charge_acengy_info = $db->get_one_info($sql1);

	$data2['recharge_dimond'] = $charge_acengy_info['recharge_dimond'] - $dimond_number;

	if($data2['recharge_dimond']<0){

		$result['code'] = 10;

		$result['msg'] = '代理拥有的钻石不够';
		
		echo json_encode($result);die;//代理拥有的钻石不够就不执行
	
	}
	
	if(!empty($user_info)){
							
		if($dimond_number<=0){
			
			$result['code'] = 11;

			$result['msg'] = '输入的钻石数为负';
			
			echo json_encode($result);die;
		
		}

		$data3 = array();

		$data3['uid'] = $uid;
		
		$data3['add_num'] = $dimond_number;

		$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
		
		$get_value = $db->get_one_info($get_value_sql);

		$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";

		$web_server = $db->get_one_info($web_server_sql);
		
		$first_log_str = 'send|'.date('Y-m-d H:i:s',time()).'|gm/add_diamond|uid:'.$uid.'-add_num:'.$dimond_number.'|agency:'.$agency_user_name;

		$first_log = $db->write_with_open('../logs/agency_to_user/'.date('Ymd',time()).'.log',$first_log_str);

		$res3 = curl_url($web_server['setting_value'],'gm/add_diamond',$data3,$get_value['setting_value']);

		$second_log_str = 'get|'.date('Y-m-d H:i:s',time()).'|'.$res3.'|agency:'.$agency_user_name;

		$second_log = $db->write_with_open('../logs/agency_to_user/'.date('Ymd',time()).'.log',$second_log_str);

		$check_res = strpos($second_log_str,'{"errorcode":0}');
	
		if(!$check_res){

			$result['code'] = 15;

			$result['msg'] = '请求接口失败！';
			
			echo json_encode($result);die;

			// $res3 = curl_url($web_server['setting_value'],'gm/add_diamond',$data3,$get_value['setting_value']);
		
			// $second_log_str = 'get|'.date('Y-m-d H:i:s',time()).'|'.$res3.'|agency:'.$agency_user_name;

			// $second_log = $db->write_with_open(date('Ymd',time()).'.log',$second_log_str);
		}

		$error_code = json_decode($res3);

		if($error_code->errorcode==0){
			
			//代理推荐的玩家购买，返卡的逻辑
			$user_uid = $user_info['uid'];
			$user_username = $user_info['username'];

			$sql_wx = "SELECT agency_id FROM `agency_to_wx_user` where uid = '$user_uid' and username = '$user_username'";
			$sql_ip = "select agency_id from `agency_to_ip_user` where uid = '$user_uid' and username = '$user_username'";

			$myself_wx = $db->get_one_info($sql_wx);
			$myself_ip = $db->get_one_info($sql_ip);

			if(!$myself_wx){
				$myself_wx = array();
			}
			if(!$myself_ip){
				$myself_ip = array();
			}

			$mysql_all = $myself_wx + $myself_ip;

			if(!empty($mysql_all)){
				$setting_sql = "select setting_value from t_system_setting where setting_name='get_inviter_buy_persent'";
				$setting_info = $db->get_one_info($setting_sql);
				$data4 = array();
				$data4['auid'] = $mysql_all['agency_id'];
				$data4['buid'] = $user_uid;
				$data4['utype'] = 1;
				$data4['buyername'] = $user_username;
				$data4['buy_dimond_num'] = $dimond_number;
				$data4['dimond_back_num'] = intval($dimond_number*$setting_info['setting_value']);
				$data4['create_time'] = time();
				$res4 = $db->insert_data($data3,'t_agency_get_dimond_back_log');

				$data4 = array();
				$auid = $data4['auid'];
				$sql2 = "select uid,recharge_dimond from t_agency where uid = '$auid'";

				$father_acengy_info = $db->get_one_info($sql2);
				$data4['recharge_dimond'] = $father_acengy_info['recharge_dimond'] + $data4['dimond_back_num'];
				$res4 = $db->update_data($data4,'t_agency',"uid = '$auid'");	
			}
					
			$res2 = $db->update_data($data2,'t_agency',"uid = '$charge_acengy'");

			$uid = $user_info['uid'];
			//代理给玩家充值
			$data = array();

			$data['dimond'] = $user_info['dimond'] + $dimond_number;
			
			$data['sum_dimond'] = $user_info['sum_dimond'] + $dimond_number;
					
			$res = $db->update_data($data,'t_game_user',"uid = '$uid'");
			//记录充值记录
			$data1 = array();

			$data1['seller_uid'] = $agency_user_name;

			$data1['buyer_uid'] = $user_info['uid'];

			$data1['buyer_name'] = $user_info['username'];
			
			$data1['user_owned_diamond'] = $user_info['dimond'];

			$data1['user_now_diamond'] = $data['dimond'];
			
			$data1['agency_owned_diamond'] = $charge_acengy_info['recharge_dimond'];
			
			$data1['agency_now_diamond'] = $data2['recharge_dimond'];
			
			$data1['dimond_num'] = $dimond_number;

			$data1['action_time'] = time();

			$res1 = $db->insert_data($data1,'t_sell_log');

			
			if($res1 && $res && $res2){
				
				$result['code'] = 1;

				$result['msg'] = '出售完成';
				
				echo json_encode($result);die;
			
			}else{

				$result['code'] = 12;

				$result['msg'] = '更新信息有误';
				
				echo json_encode($result);die;
			
			}
		
		}else{

			$result['code'] = 13;

			$result['msg'] = '玩家增加房卡失败';

			echo json_encode($result);die;
		
		}
	
	}else{

		$result['code'] = 14;

		$result['msg'] = '玩家信息有误';

		echo json_encode($result);die;
	
	}


	
}



function curl_url($web_server,$part,$data,$port){
	$uid = $data['uid'];
	$num = $data['add_num'];
	$url = '127.0.0.1'.':'.$port.'/'.$part."?user_id=$uid&add_num=$num";
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $url);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 2);
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	$errno = curl_errno($ch);
	curl_close($ch);
	if($errno!=0){
		$error_message = curl_error($ch);
		$output .= '|'.$errno.':'.$error_message;
		return $output;
	}	
	//释放curl句柄
	
	//打印获得的数据		
	return $output;
}

 
// die;




