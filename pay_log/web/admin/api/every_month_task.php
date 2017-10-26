<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

function every_agency_get_money($db){
	$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
	$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));

	$user_use_dimond_sql = "select sum(use_dimond) as total_used_dimond_num,uid from t_user_dimond_log where use_time between $beginThismonth and $endThismonth";
	
	$all_user_use_dimond = $db->fetchAll($user_use_dimond_sql);

	$data = array();
	$data['auid'] = '';
	$data['back_money'] = '';
	$data['back_date'] = '';

	$setting_back_money_sql = "select setting_value from t_system_setting where setting_name='get_inviter_money_persent'";
	$setting_back_money = $db->get_one_info($setting_back_money_sql);

	if($all_user_use_dimond){
		foreach ($all_user_use_dimond as $k => $v) {
			$uid = $v['uid'];

			$agency_sql1 = "select agency_id from agency_to_ip_user where uid='$uid'";

			$agency_info1 = $db->get_one_info($agency_sql1);

			if($agency_info1){
				$auid = $agency_info1['agency_id'];		
				$back_money = $setting_back_money['setting_value']*$v['total_used_dimond_num'];
			}
					
			$agency_sql2 = "select agency_id from agency_to_wx_user where uid='$uid'";
			$agency_info2 = $db->get_one_info($agency_sql2);
			
			if($agency_info2){
				$auid = $agency_info2['agency_id'];		
				$back_money = $setting_back_money['setting_value']*$v['total_used_dimond_num'];		
			}

			$back_date = date('Y-m',$beginThismonth);
			$data['back_money'] = $back_money;
			$data['back_date'] = $back_date;
			$data['back_create_time'] = time();
			if(!empty($auid)){
				$data['auid'] = $auid;
			}else{
				$data['auid'] = '无';
			}
			
			$check_sql = "select id from t_every_month_money_back where back_date = '$back_date' and auid='$auid'";		
			$check = $db->get_one_info($check_sql);

			if($check){
				$id = $check['id'];
				$res = $db->update_data($data,'t_every_month_money_back',"id=$id");
			}else{
				$res = $db->insert_data($data,'t_every_month_money_back');
			}				
		}
	}
}

function every_agency_get_dimond($db){
	$all_agency_sql = 'select uid from t_agency';
	$all_agency_info = $db->fetchAll($all_agency_sql);
	$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
	$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));

	$setting_back_dimond_sql = "select setting_value from t_system_setting where setting_name='get_inviter_use_persent'";
	$setting_back_dimond = $db->get_one_info($setting_back_dimond_sql);

	foreach ($all_agency_info as $k => $v) {
		$auid = $v['uid'];

		$agency_sql1 = "select uid from agency_to_ip_user where agency_id='$auid'";
		$agency_info1 = $db->fetchAll($agency_sql1);
		$data = array();
		$data['pay_person_num'] = 0;
		$data['pay_person_dimond_num'] = 0;
		$data['get_money'] = 0;
		if(!empty($agency_info1)){
			foreach ($agency_info1 as $k1 => $v1) {
				$uid1 = $v1['uid'];
				$user_use_dimond_sql1 = "select sum(use_dimond) as total_used_dimond_num,uid from t_user_dimond_log where use_time between $beginThismonth and $endThismonth and uid=$uid1";	
				$all_user_use_dimond1 = $db->fetchAll($user_use_dimond_sql1);
				foreach ($all_user_use_dimond1 as $k2 => $v2) {
					if(!empty($v2['total_used_dimond_num']) &&!empty($v2['uid'])){
						$data['pay_person_num'] = $data['pay_person_num'] + 1;
						$data['pay_person_dimond_num'] = $data['pay_person_dimond_num']+$v2['total_used_dimond_num'];
						$data['get_money'] = $data['get_money'] + $setting_back_dimond['setting_value']*$v2['total_used_dimond_num'];
						
					}
				}						
			}		
		}
		
		$agency_sql2 = "select uid from agency_to_wx_user where agency_id='$auid' and uid is not null and username is not null";
		$agency_info2 = $db->fetchAll($agency_sql2);
		if(!empty($agency_info2)){
			foreach ($agency_info2 as $k3 => $v3) {
				$uid2 = $v3['uid'];
				$user_use_dimond_sql2 = "select sum(use_dimond) as total_used_dimond_num,uid from t_user_dimond_log where use_time between $beginThismonth and $endThismonth and uid=$uid2";	
				$all_user_use_dimond2 = $db->fetchAll($user_use_dimond_sql2);
				foreach ($all_user_use_dimond2 as $k3 => $v3) {
					if(!empty($v3['total_used_dimond_num']) &&!empty($v3['uid'])){
						$data['pay_person_num'] = $data['pay_person_num'] + 1;
						$data['pay_person_dimond_num'] = $data['pay_person_dimond_num']+$v3['total_used_dimond_num'];
						$data['get_money'] = $data['get_money'] + $setting_back_dimond['setting_value']*$v3['total_used_dimond_num'];
						
					}
				}		
				
			}
		}

		if($data['pay_person_num']>0){
			
			$check_sql = "select id from t_money_back_log where auid='$auid'";
			$check = $db->get_one_info($check_sql);
			if($check){
				$id = $check['id'];
				$res = $db->update_data($data,'t_money_back_log',"id = $id");
			}else{
				$data['get_money_time'] = time();
				$data['auid'] = $auid;
				$res = $db->insert_data($data,'t_money_back_log');
			}
		}		
	}
}



// var_dump($all_agency_info);


function every_month_task($db){
	every_agency_get_money($db);
	every_agency_get_dimond($db);
}

$t1 = microtime(true);

every_month_task($db);

$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3).'秒<br>';
echo 'Now memory_get_usage: ' . memory_get_usage() . '<br />';



echo '处理完成';
die;