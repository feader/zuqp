<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';
require_once '../../config/config.php';

//初始化日志
// $logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
// $log = Log::Init($logHandler, 15);

$pay_info = array();

//打印输出数组信息
// function printf_info($data)
// {
//     foreach($data as $key=>$value){
//         echo "<font color='#00ff55;'>$key</font> : $value <br/>";
//     }
// }

$type = $_GET['tid'];

$gid = $_GET['gid'];

function get_type_info($gid,$type){
	switch ($gid.$type) {
		case '11':
			$pay_info['price'] = 12;
			$pay_info['num'] = 12;
			break;
		case '12':
			$pay_info['price'] = 30;
			$pay_info['num'] = 30;
			break;
		case '13':
			$pay_info['price'] = 138;
			$pay_info['num'] = 138;
			break;
		case '21':
			$pay_info['price'] = 12;
			$pay_info['num'] = 12;
			break;
		case '22':
			$pay_info['price'] = 36;
			$pay_info['num'] = 36;
			break;
		case '23':
			$pay_info['price'] = 138;
			$pay_info['num'] = 138;
			break;
		case '31':
			$pay_info['price'] = 12;
			$pay_info['num'] = 12;
			break;
		case '32':
			$pay_info['price'] = 60;
			$pay_info['num'] = 60;
			break;
		case '33':
			$pay_info['price'] = 138;
			$pay_info['num'] = 138;
			break;						
		default:
			$pay_info['price'] = 999999;
			$pay_info['num'] = 0;
			break;
	}
	return $pay_info;
}

$pay_info = get_type_info($gid,$type);

$price = $pay_info['price']*100;

$num = $pay_info['num'];

$gid = $_GET['gid'];

$uid = $_GET['uid'];

$auid = $_GET['auid'];

$common = new config();

$notify_url = $common->change_order_url($gid);

$trade_no = WxPayConfig::MCHID.date("YmdHis").rand(1111,9999);

$data = array();
$data['trade_no'] = $trade_no;
$data['price'] = $pay_info['price'];
// $data['price'] = 0.01;
$data['num'] = $num;
$data['uid'] = $uid;
if(isset($_GET['auid']) && !empty($_GET['auid'])){
	$data['auid'] = $auid;
}

$post_url = $common->make_charge_order_url($gid);

$res = $common->curl_post($post_url,$data);
// var_dump($res);die;
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
// var_dump($openId);die;
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody('打赏'.$pay_info['price'].'元得'.$num.'张房卡');
$input->SetAttach("个人房卡充值");
$input->SetOut_trade_no($trade_no);
// $input->SetTotal_fee($price);
$input->SetTotal_fee(1);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("打赏赠房卡");
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
    <script type="text/javascript" src="../../../../static/js/jquery-2.0.0.js"></script>
    <title>在线支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				// alert(res.err_code+res.err_desc+res.err_msg);
				if(res.err_msg=='get_brand_wcpay_request:ok'){
					alert('支付完成,请关闭页面返回公众号！');
				}else{
					alert('未支付完成,请关闭页面返回公众号！');
				}				
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
    
	<font color="#9ACD32">
		<b>此次打赏金额为<span style="color:#f00;font-size:30px"><?php echo $pay_info['price'];?>元</span>钱</b>
		<p class='show_back_code'></p>
	</font>
		
	<script>
		
		callpay();	

	</script>
</body>
</html>