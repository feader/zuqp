<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$res2 = $GLOBALS['HTTP_RAW_POST_DATA'];

$res1 = $_GET['res'];

$data3 = array();

$data3['text_conent'] = $res2;

$res3 = $db->insert_data($data3,'t_test_log');

function xmlToArray($xml){    
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
    return $values;
}

// $res = xmlToArray($res1);
$res = xmlToArray($GLOBALS['HTTP_RAW_POST_DATA']);

if(array_key_exists('return_code', $res) && array_key_exists('result_code', $res) && $res["return_code"] == 'SUCCESS' && $res["result_code"] == 'SUCCESS'){	

	$log = '';

	foreach ($res as $k => $v) {
		if($k=='openid'||$k=='out_trade_no'||$k=='time_end'||$k=='total_fee'||$k=='cash_fee'||$k=='transaction_id'){
			$log .= $k.'-'.$v.'|'; 
		}	
	}

	$order_id = $res['out_trade_no'];
	
	$price = $res['total_fee']/100;
	
	$check_sql = "select trade_no,dimond,price,id,uid from t_user_charge_order where trade_no='$order_id' and price = $price";
	
	$check = $db->get_one_info($check_sql);
	
	if($check['status']!=1){
		
		//更改订单状态为1，完成订单
		
		$id = $check['id'];
		$data = array();
		$data['status'] = 1;	
		$data['transaction_id'] = $res['transaction_id'];
		$data['finish_time'] = time();
		$data['wx_back_info'] = $log;
		$update_user_charge_order = $db->update_data($data,'t_user_charge_order',"id=$id");

		$uid = $check['uid'];

		$db->delete_data('t_user_charge_order',"uid = '$uid' and status = 0");

		$check_user_sql = "select uid,dimond from t_game_user where uid = '$uid'";
		$check_user = $db->get_one_info($check_user_sql);

		if(!empty($check_user)){
			$data1 = array();	
			$data1['dimond'] = $check_user['dimond']+$check['dimond'];
			//$data1['dimond'] = $check_user['dimond']+1;
			$data1['last_dimond_charge_time'] = time();
			$update_user_dimond = $db->update_data($data1,'t_game_user',"uid='$uid'");

			$data2 = array();

			$data2['uid'] = $uid;
			
			$data2['add_num'] = $check['dimond'];
			//$data2['add_num'] = 1;

			$get_value_sql = "select setting_value from t_system_setting where setting_name='interface_port_num'";
			
			$get_value = $db->get_one_info($get_value_sql);

			$web_server_sql = "select setting_value from t_system_setting where setting_name='web_server'";
			
			$web_server = $db->get_one_info($web_server_sql);

			$add_res = curl_url($web_server['setting_value'],'gm/add_diamond',$data2,$get_value['setting_value']);

			echo 'SUCCESS';die;
		
		}else{
			echo 'Fail1';die;
		}		
	}else{
			echo 'Fail2';die;
	}	
}else{
	echo 'Fail3';die;
}



function curl_url($server,$part,$data,$port){
	$uid = $data['uid'];
	$num = $data['add_num'];
	$url = $server.':'.$port.'/'.$part."?user_id=$uid&add_num=$num";	
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






// echo json_encode($res1);die;







// <xml>
// <appid><![CDATA[wx5f5a378fbcd87e06]]></appid>
// <attach><![CDATA[个人房卡充值]]></attach>
// <bank_type><![CDATA[CFT]]></bank_type>
// <cash_fee><![CDATA[1]]></cash_fee>
// <fee_type><![CDATA[CNY]]></fee_type>
// <is_subscribe><![CDATA[Y]]></is_subscribe>
// <mch_id><![CDATA[1480084612]]></mch_id>
// <nonce_str><![CDATA[f9s5lv2rckvcdm14q0hfyzy02k0stit5]]></nonce_str>
// <openid><![CDATA[oPriev1i_d4WwX99MB3fEnrScm3A]]></openid>
// <out_trade_no><![CDATA[1480084612201707141518217144]]></out_trade_no>
// <result_code><![CDATA[SUCCESS]]></result_code>
// <return_code><![CDATA[SUCCESS]]></return_code>
// <sign><![CDATA[905BA099CC3BFF476EEB7E758B7B797E]]></sign>
// <time_end><![CDATA[20170714151828]]></time_end>
// <total_fee>1</total_fee>
// <trade_type><![CDATA[JSAPI]]></trade_type>
// <transaction_id><![CDATA[4009842001201707140731953209]]></transaction_id>
// </xml>


