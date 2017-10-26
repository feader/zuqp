<?php
define('IN_DATANG_SYSTEM', true);
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once "../../../../../config/config.php";
require_once '../../../../include/global2.php';
global $db;


require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

$data = array();
// $data['text_conent'] = $_POST;
$data['text_conent'] = $GLOBALS['HTTP_RAW_POST_DATA'];
$res = $db->insert_data($data,'t_test_log');

//回调数据处理，根据回调信息，为success的时候查询订单状态是否为1，为0则进行数据更新
function xmlToArray($xml){    
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
    return $values;
}

$res = xmlToArray($GLOBALS['HTTP_RAW_POST_DATA']);

if(array_key_exists("return_code", $res) && array_key_exists("result_code", $res) && $res["return_code"] == "SUCCESS" && $res["result_code"] == "SUCCESS"){	
	
	$order_id = $res['out_trade_no'];
	$check_sql = "select order_id,order_status,dimond_number,gift_dimond_number,money_number,uid from t_recharge_log where order_id='$order_id'";
	$check = $db->get_one_info($check_sql);

	if($check['order_status']!=1){
		//更改订单状态为1，完成订单
		$data = array();
		$data['order_status'] = 1;	
		$data['alipay_order_id'] = $res['transaction_id'];
		$data['finish_time'] = time();
		$order = $db->update_data($data,'t_recharge_log',"order_id = '$order_id' and pay_way='wxpay'");

		$user_id = $check['uid'];

		//更新代理的钻石与金额
		$sql = "UPDATE t_agency SET ". 
					" recharge_dimond = recharge_dimond + " .$check['dimond_number']. 
					", recharge_send_dimond = recharge_send_dimond + " .$check['gift_dimond_number']. 
					", recharge_money = recharge_money + " .($check['money_number']/100). 
					" WHERE uid = '$user_id';";
		$result = $db->query($sql);
	}
}

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id,$db)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
