<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;

if($_GET['action'] == 'save' ){

	$dateStart = strtotime($_GET['start_time']);
	$dateEnd = strtotime($_GET['end_time']);

	$data = array();
	$data['start_time'] = $dateStart;
	$data['end_time'] = $dateEnd;
	$data['join_point'] = $_GET['join_point'];
	$res = $db->update_data($data,'t_offline_play_setting',"id = 1");

	if($res){

		$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
		$get_value = $db->get_one_info($get_value_sql);

		$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";
		$web_server = $db->get_one_info($get_value_sql);

		$curl_res = curl_url($web_server['setting_value'],'gm/modify_offline_competition_time',$data,$get_value['setting_value']);
		// var_dump($curl_res);die;
		$db->jump('编辑成功！','off_line_play_setting.php');
	}else{
		$db->jump('编辑失败或没变化！','off_line_play_setting.php');
	}
	
}


$sql = "select * from t_offline_play_setting where id = 1";
$setting = $db->get_one_info($sql);
$data_time = array();
$data_time['start_time'] = date('Y-m-d',$setting['start_time']);
$data_time['end_time'] = date('Y-m-d',$setting['end_time']);

$smarty->assign("setting", $setting);
$smarty->assign("data_time", $data_time);
$smarty->display("module/admin/off_line_play_setting.html");

function curl_url($web_server,$part,$data,$port){
	$start_time = $data['start_time'];
	$end_time = $data['end_time'];
	$joinpoint = $data['join_point'];
	$url = $web_server.':'.$port.'/'.$part."?start=$start_time&end=$end_time&needpoint=$joinpoint";	
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