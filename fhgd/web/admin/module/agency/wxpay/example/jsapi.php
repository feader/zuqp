<?php 
define('IN_DATANG_SYSTEM', true);
require_once "../../../../../config/config.php";
require_once '../../../../include/global2.php';
global $db,$dbConfig;
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';
require_once '../../agency_recharge_config.php';
//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

$setting_sql = "select setting_value from t_system_setting where setting_name = 'web_url'";

$setting = $db->get_one_info($setting_sql);

$notify_url = $setting['setting_value'].'web/admin/module/agency/wxpay/example/notify_ys.php';

$product_id = 1;

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

$subject = '微信购买'.$dimond_cnt . "钻石，赠送" . $gift_dimond_cnt . "钻石";

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


//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody($subject);
$input->SetAttach('代理房卡充值');
$input->SetOut_trade_no($order_id);
$input->SetTotal_fee($total_fee);
// $input->SetTotal_fee("1");
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag('代理房卡充值');
$input->SetNotify_url($notify_url);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
// echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付样例-支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				if(res.err_msg=='get_brand_wcpay_request:ok'){
					alert('支付完成！');
				}else{
					alert('未支付完成！');
				}	
				location.href="http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/module/agency/index.php";
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
				//alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	
	</script>
</head>
<body>
    <br/>
    <font color="#9ACD32"><b>该笔支付金额为<span style="color:#f00;font-size:50px"><?php echo $total_fee;?>元</span>钱</b></font><br/><br/>
	<div align="center">
		<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
	</div>
</body>
</html>