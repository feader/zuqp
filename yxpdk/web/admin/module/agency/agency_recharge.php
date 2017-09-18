<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
include SYSDIR_ROOT_CLIENT.'alipay/alipay.config.php';
include SYSDIR_ROOT_CLIENT.'alipay/lib/alipay_submit.class.php';
require_once 'agency_recharge_config.php';

global $smarty, $db,$dbConfig;

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$auid = $session_data['auid'];
$uid = $auid;

// print_r($_REQUEST);
$action = trim($_REQUEST['action']);
if ($action == 'recharge') {

	/**************************请求参数**************************/

	$product_id = SS($_REQUEST['product_id']);

	$pay_info = get_value($product_id,$pay_config);

	$dimond_cnt = $pay_info['dimond_cnt'];
	$gift_dimond_cnt = $pay_info['gift_dimond_cnt'];
	$total_fee = $pay_info['total_fee'];
	// $total_fee = 0.01;
	
	//商户订单号，商户网站订单系统中唯一订单号，必填
	$out_trade_no = make_order();

	//订单名称，必填
	$subject = '购买'.($dimond_cnt-$gift_dimond_cnt) . '钻石，赠送' . $gift_dimond_cnt . '钻石';

	//付款金额，必填
	// $total_fee = $_REQUEST['WIDtotal_fee'];
	$total_fee_fen = $total_fee * 100; // 人民币分

	//收银台页面上，商品展示的超链接，必填
	$show_url = $_REQUEST['WIDshow_url'];

	//商品描述，可空
	$body = $_REQUEST['WIDbody'];

	$now = time();

	// 将订单写入数据库
	$sql = "INSERT INTO t_recharge_log (order_id, order_status, uid, dimond_number, money_number, gift_dimond_number, create_time, `desc`)
			VALUES ('$out_trade_no', 0, '$uid', $dimond_cnt, $total_fee_fen, $gift_dimond_cnt, $now, '$subject');";
	$result = $db->query($sql);
	if (empty($result)) {
		echo "创建订单失败！";
		die();
	}

	/************************************************************/

	//构造要请求的参数数组，无需改动
	$parameter = array(
			"service"       => $alipay_config['service'],
			"partner"       => $alipay_config['partner'],
			"seller_id"  => $alipay_config['seller_id'],
			"payment_type"	=> $alipay_config['payment_type'],
			"notify_url"	=> $alipay_config['notify_url'],
			"return_url"	=> $alipay_config['return_url'],
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
			"out_trade_no"	=> $out_trade_no,
			"subject"	=> $subject,
			"total_fee"	=> $total_fee,
			"show_url"	=> $show_url,
			//"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
			"body"	=> $body,
			//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
	        //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。
			
	);

	//建立请求
	$alipaySubmit = new AlipaySubmit($alipay_config);
	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	echo $html_text;

}
$smarty->assign('pay_config', $pay_config);
$smarty->display("module/agency/agency_recharge.html");


function make_order()
{
	list($usec, $sec) = explode(" ", microtime());
	$msec = round($usec*1000000);
	return date('YmdHis') . $msec;

}