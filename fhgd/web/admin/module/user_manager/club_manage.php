<?php
header("Content-Type: text/html; charset=UTF-8");
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;

$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
$get_value = $db->get_one_info($get_value_sql);

$action = $_GET['action'];
$result = array();

if($action=='add'){

	$uid = $_GET['uid'];
	$part = $_GET['part'];
	$data = '?player_id='.$uid;
	$port = $get_value['setting_value'];
	$res = curl_url($part,$data,$port);
	$back = json_decode($res,true);

	// 1001 没有该玩家
	// 1002 已是其他俱乐部群主
	// 1003 已有俱乐部
	// 1004 写数据库失败

	$user_sql = "select username from t_game_user where uid='$uid'";
	$user_info = $db->get_one_info($user_sql);
	
	if($back['errorcode']==0){
		$result['code'] = 0;
		$result['msg'] = '昵称：'.$user_info['username'].',成功新增俱乐部!俱乐部ID：'.$back['club_id'];
		echo json_encode($result);die;
	}

	if($back['errorcode']==1001){
		$result['code'] = 1001;
		$result['msg'] ='没有该玩家';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1002){
		$result['code'] = 1002;
		$result['msg'] = '昵称：'.$user_info['username'].',已是其他俱乐部群主';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1003){
		$result['code'] = 1003;
		$result['msg'] = '昵称：'.$user_info['username'].',已有俱乐部';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1004){
		$result['code'] = 1004;
		$result['msg'] = '写数据库失败';
		echo json_encode($result);die;
	}
	
	$result['code'] = 1005;
	$result['msg'] ='出错';
	echo json_encode($result);die;
	
}

if($action=='del'){

	$uid = $_GET['uid'];
	$part = $_GET['part'];
	$club_id = $_GET['club_id'];
	$data = '?player_id='.$uid.'&club_id='.$club_id;
	$port = $get_value['setting_value'];
	$res = curl_url($part,$data,$port);
	$back = json_decode($res,true);

	$user_sql = "select username from t_game_user where uid='$uid'";
	$user_info = $db->get_one_info($user_sql);

	// 1001 俱乐部不存在
	// 1002 没有该玩家
	// 1003 已有俱乐部
	// 1004 还有多个俱乐部成员
	// 1005 不是群主不能删除俱乐部
	
	if($back['errorcode']==0){
		$result['code'] = 0;
		$result['msg'] = '昵称：'.$user_info['username'].',删除成功';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1001){
		$result['code'] = 1001;
		$result['msg'] = '俱乐部不存在';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1002){
		$result['code'] = 1002;
		$result['msg'] = '没有该玩家';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1003){
		$result['code'] = 1003;
		$result['msg'] = '已有俱乐部';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1004){
		$result['code'] = 1004;
		$result['msg'] = '还有多个俱乐部成员';
		echo json_encode($result);die;
	}

	if($back['errorcode']==1005){
		$result['code'] = 1005;
		$result['msg'] = '昵称：'.$user_info['username'].',不是群主不能删除俱乐部';
		echo json_encode($result);die;
	}
	
	$result['code'] = 1006;
	$result['msg'] ='出错';
	echo json_encode($result);die;
	
}

if($action=='check'){

	$uid = $_GET['uid'];
	$part = $_GET['part'];
	$data = '?player_id='.$uid;
	$port = $get_value['setting_value'];
	$res = curl_url($part,$data,$port);
	$back = json_decode($res,true);

	$user_sql = "select username from t_game_user where uid='$uid'";
	$user_info = $db->get_one_info($user_sql);

	// 1001 没有该玩家
	// 1002 已是其他俱乐部群主
	// 1003 已有俱乐部
	// 1004 写数据库失败
	
	if($back['errorcode']==0){
		$result['code'] = 0;
		$result['msg'] = '昵称：'.$user_info['username'].',该玩家俱乐部ID：'.$back['club_id'];
		echo json_encode($result);die;
	}

	if($back['errorcode']==1001){
		$result['code'] = 1001;
		$result['msg'] ='没有该玩家';
		echo json_encode($result);die;
	}

	$result['code'] = 1002;
	$result['msg'] ='出错';
	echo json_encode($result);die;
	
}


function curl_url($part,$data,$port){
	$url = '127.0.0.1:'.$port.'/'.$part.$data;	
	// $url = '127.0.0.1:'.'28086'.'/'.$part.$data;	
	//var_dump($url);die;
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

$smarty->display("module/user_manager/club_manage.html");