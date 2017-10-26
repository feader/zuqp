<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db;

$note_sql = 'select * from t_system_setting where setting_name="game_notice"';
$note_detail = $db->get_one_info($note_sql);

if($_POST['action']=='edit'){
	
	$data = array();
	
	$data['setting_value'] = $_POST['setting_value'];
	
	$id = $_POST['id'];
	
	$res = $db->update_data($data,'t_system_setting',"id=$id");

	$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
		
	$get_value = $db->get_one_info($get_value_sql);

	$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";
	
	$web_server = $db->get_one_info($web_server_sql);

	$res1 = curl_url($web_server['setting_value'],'gm/set_billboard_content',$data,$get_value['setting_value']);

	$res_code = json_decode($res1);

	$code = $res_code->errorcode;

	if($code==0){

		$db->jump('编辑成功！');

	}else{
		
		$db->jump('内容没变化或编辑失败！');
	
	}
	
}

$smarty->assign("note_detail", $note_detail);
$smarty->display("module/game_manager/game_notice.html");


function curl_url($web_server,$part,$data,$port){
	$content = $data['setting_value'];
	//$url = $web_server.':'.$port.'/'.$part."?content=$content";
	$url = '127.0.0.1:'.$port.'/'.$part."?content=$content";
	// var_dump($url);die;
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