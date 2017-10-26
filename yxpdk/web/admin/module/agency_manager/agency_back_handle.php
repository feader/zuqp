<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db;

$id = $_GET['id'];
$action = $_GET['action'];
$result = array();
$data = array();

if($action=='handle_money'){
	
	$check_sql = "select id,status from t_every_month_money_back where id=$id";
	
	$check = $db->get_one_info($check_sql);
	
	if($check['status']==0){	
		
		$data['back_time'] = time();
		
		$data['status'] = 1;
		
		$res = $db->update_data($data,'t_every_month_money_back',"id=$id");	
		
		if($res){
			
			$result['code'] = 1;
			
			$result['msg'] = '发放成功！';
		
		}else{
			
			$result['code'] = 0;
			
			$result['msg'] = '发放失败！';
		
		}
	}else{
		
		$result['code'] = 0;
		
		$result['msg'] = '已发放，重复点击！';
	
	}
	
	echo json_encode($result);

}

if($action=='handle_dimond'){
	
	$check_sql = "select id,status,auid,get_money from t_money_back_log where id=$id";
	
	$check = $db->get_one_info($check_sql);
	
	if($check['status']==0){	
		
		$data['handle_time'] = time();
		
		$data['status'] = 1;
		
		$agency_info_sql = "select uid,id,recharge_dimond from t_agency where uid='$check[auid]'";
		
		$agency_info = $db->get_one_info($agency_info_sql);

		$log = array(

			'auid' => $check[auid],
			'diamond' => $check['get_money'],
			'handler' => 'system',
			'create_time' => time(),
			'note' => '后台手动点击发放奖励房卡:'.$check['get_money'].'张',

		);
		

		if($agency_info){
			
			$data2 = array();
		
			$data2['recharge_dimond'] = intval($agency_info['recharge_dimond'] + $check['get_money']);

			$aid = $agency_info['id'];

			$res1 = $db->update_data($data2,'t_agency',"id=$aid");

			if($res1){
				
				$log_res = $db->insert_data($log,'t_agency_diamond_change_log');
			
			}
	
		}else{

			$result['code'] = 0;
		
			$result['msg'] = '代理信息错误，发放失败！';
		
		}
						
		$res = $db->update_data($data,'t_money_back_log',"id=$id");	
		
		if($res && $res1){
		
			$result['code'] = 1;
		
			$result['msg'] = '发放成功！';
		
		}else{
		
			$result['code'] = 0;
		
			$result['msg'] = '发放失败！';
		
		}

	}else{
		
		$result['code'] = 0;
		
		$result['msg'] = '已发放，重复点击！';
	
	}
	
	echo json_encode($result);
}

die;