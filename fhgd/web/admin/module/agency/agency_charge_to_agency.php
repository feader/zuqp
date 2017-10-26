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

if($action =='search_agency'){
	//上级代理给下级代理充值前的检查
	$username = $db->check_input($_GET['username']);

	if($_GET['username'] == $agency_user_name){

		$result['code'] = 10;

		$result['msg'] = '代理名前后不一致';
		
		die(json_encode($result));

	}
	
	$sql = "select uid from t_agency where uid = $username";

	$user_info = $db->get_one_info($sql);

	if(!empty($user_info)){
		
		die(json_encode($user_info));
	
	}else{
		$result['code'] = 11;

		$result['msg'] = '代理不存在';
		
		die(json_encode($result));
	}

}else if($action =='handle'){
	//上级代理给下级代理充值
	$username = $_GET['username'];
	
	$username = $db->check_input($username);

	$sql = "select uid,recharge_dimond,uber_agency from t_agency where uid = $username";
	//查询要充值的代理信息
	$user_info = $db->get_one_info($sql);

	if(!empty($user_info)){
		
		$dimond_number = $_GET['dimond_number'];
		
		$dimond_number = $db->check_input($dimond_number);

		if($dimond_number<=0){
			
			$result['code'] = 12;

			$result['msg'] = '房卡数为负数';
		
			echo json_encode($result);die;
		
		}

		$uid = $user_info['uid'];
		
		$charge_acengy = $agency_user_name;

		//卖家代理的数据更新
		$data1 = array();

		$sql1 = "select uid,recharge_dimond from t_agency where uid = '$charge_acengy'";

		$charge_acengy_info = $db->get_one_info($sql1);

		$data1['recharge_dimond'] = $charge_acengy_info['recharge_dimond'] - $dimond_number;

		if($data1['recharge_dimond']<0){
			
			$result['code'] = 13;

			$result['msg'] = '可充值房卡数为负数';
		
			echo json_encode($result);die;
		
		}

		//出售给推荐代理的返卡
		if(!empty($user_info['uber_agency'])){
			$uber_agency = $user_info['uber_agency'];

			$setting_sql = "select setting_value from t_system_setting where setting_name='get_inviter_buy_persent'";
			$setting_info = $db->get_one_info($setting_sql);

			$data3 = array();
			$data3['auid'] = $uber_agency;
			$data3['buid'] = $uid;
			$data3['utype'] = 2;
			$data3['buyername'] = $uid;
			$data3['buy_dimond_num'] = $dimond_number;
			$data3['dimond_back_num'] = intval($dimond_number*$setting_info['setting_value']);
			$data3['create_time'] = time();
			$res3 = $db->insert_data($data3,'t_agency_get_dimond_back_log');

			$data4 = array();
			$auid = $data3['auid'];
			$sql2 = "select uid,recharge_dimond from t_agency where uid = '$uber_agency'";

			$father_acengy_info = $db->get_one_info($sql2);
			$data4['recharge_dimond'] = $father_acengy_info['recharge_dimond'] + $data3['dimond_back_num'];
			$res4 = $db->update_data($data4,'t_agency',"uid = '$uber_agency'");	
		}

		
		//买家代理的数据更新
		$data = array();

		$data['recharge_dimond'] = $user_info['recharge_dimond'] + $dimond_number;
				
		//记录充值记录
		$data2 = array();

		$data2['sell_agency_uid'] = $charge_acengy;

		$data2['buy_agency_uid'] = $user_info['uid'];
			
		$data2['dimond_num'] = $dimond_number;

		$data2['create_time'] = time();

		$res = $db->update_data($data,'t_agency',"uid = '$uid'");

		$res1 = $db->update_data($data1,'t_agency',"uid = '$charge_acengy'");

		$res2 = $db->insert_data($data2,'t_agency_sell_to_agency');

		if($res && $res1 && $res2){
			
			$result['code'] = 1;

			$result['msg'] = '充值成功';
		
			echo json_encode($result);die;
		
		}else{
			
			$result['code'] = 1;

			$result['msg'] = '充值失败';

			echo json_encode($result);die;
		
		}

		//var_dump($res1);
	
	}


	
}



 
// die;




