<?php
define('IN_DATANG_SYSTEM', true);
require_once "../../../../../config/config.php";
require_once '../../../../include/global2.php';
global $db,$dbConfig;
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

$setting_sql = "select setting_value from t_system_setting where setting_name = 'web_url'";

$setting = $db->get_one_info($setting_sql);

$notify_url = $setting['setting_value'].'web/admin/module/agency/wxpay/example/notify.php';

require_once "../lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';
require_once '../../agency_recharge_config.php';

$product_id = $_GET['product_id'];

$pay_info = get_value($product_id,$pay_config);

$dimond_cnt = $pay_info['dimond_cnt'];
$gift_dimond_cnt = $pay_info['gift_dimond_cnt'];
$total_fee = $pay_info['total_fee'];

function make_order(){
	$str = date('YmdHis').rand(111111,999999);
	return $str;
}

$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
$session_data = get_session($dbname);
$auid = $session_data['auid'];
$uid = $auid;

$subject = '购买'.($dimond_cnt-$gift_dimond_cnt) . "钻石，赠送" . $gift_dimond_cnt . "钻石";

$order_id = make_order();
$data = array();
$data['order_id'] = $order_id;
$data['order_status'] = 0;
$data['uid'] = $uid;
$data['dimond_number'] = $dimond_cnt;
$data['money_number'] = $total_fee*100;
// $data['money_number'] = 1;
$data['gift_dimond_number'] = 0;
$data['create_time'] = time();
$data['desc'] = $subject;
$data['pay_way'] = 'wxpay';

$res = $db->insert_data($data,'t_recharge_log');

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
//$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody($subject);
$input->SetAttach($subject);
$input->SetOut_trade_no($data['order_id']);
$input->SetTotal_fee($total_fee*100);
// $input->SetTotal_fee('1');
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag($subject);
$input->SetNotify_url($notify_url);
$input->SetTrade_type("NATIVE");
$input->SetProduct_id($data['order_id']);
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"> 
    <title>扫码支付</title>
    <script type="text/javascript" src="../../../../static/js/jquery.min.js"></script>
</head>
<body>
	
	<div style="margin: 0px auto;color:#556B2F;font-size:30px;font-weight: bolder;">
		<p style="text-align:center;">请用微信扫一扫或利用二维码识别完成支付</p>
	</div>
	<br/>
	<div style="width:300px;height:300px;margin:0 auto;" id="show_qrcode">
		<img src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:300px;height:300px;"/>
	</div>
	<div style="margin: 0px auto;font-size:30px;font-weight: bolder;">
		<p style="text-align:center;">
			<a href="show_code.php?src=http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>&oid=<?php echo $order_id;?>" style='color:#556B2F;' target="_blank">ios用户或者没法唤起二维码识别的手机用户请点击这里</a>
		</p>
	</div>
	<div style="width:300px;margin:0 auto;">
		<p style="text-align:center;">
			<a href="javascript:history.back()">返回上一页</a>
		</p>	
	</div>
<script>

	function get_order_res(){		
		var order_id = <?php echo "'$order_id'";?>;
		$.ajax({
            dataType:'json',
            url:'../../recharge_wxpay.php?action=get_order_res',
            type:'get',
            data:{order_id:order_id},
            success:function(res){
                if(res){
                	alert('支付完成！');
                	window.location.href = '../../agency_recharge_log.php';
                }
            }
        })
	}
	
	function auto_check(){
		get_order_res();
        setInterval("get_order_res()",5000);
	}
auto_check();
</script>	
</body>
</html>