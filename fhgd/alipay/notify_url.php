<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
define('IN_DATANG_SYSTEM', true);
include "../web/config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $db;

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");



//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号
	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号
	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

     	$sql = "select * from t_recharge_log where order_id = '$out_trade_no'";
     	$order = $db->fetchOne($sql);

     	if (empty($order)) {
     		
            logResult("验证失败，找不到相关的订单号, out_trade_no:" . $out_trade_no . " trade_no:" . $trade_no);
     	
        }else{
     		
            if ($order['order_status'] == 0) {
     			// 订单尚未处理
     			$finish_time = time();
     			$order_status = $trade_status == 'TRADE_SUCCESS' ? 1 : 2; // TRADE_SUCCESS=1, TRADE_SUCCESS=2
     			$sql1 = "update t_recharge_log set alipay_order_id = '{$trade_no}', order_status = $order_status, finish_time = $finish_time where order_id = '$out_trade_no'";
     			$db->query($sql1);

                
                // 玩家uid
                $user_id = $order['uid'];
     			$sql2 = "UPDATE t_agency SET ". 
     						" recharge_dimond = recharge_dimond + " .$order['dimond_number']. 
     						", recharge_send_dimond = recharge_send_dimond + " .$order['gift_dimond_number']. 
     						", recharge_money = recharge_money + " .$order['money_number']. 
     						" WHERE uid = '$user_id';";
     			$result = $db->query($sql2);
     			if (!empty($result)) {
     				logResult("充值成功\n");
     			}else{
     				logResult("充值失败，更新玩家钻石出现错误！sql: " . $sql . "\n");
     			}
     		}else{
     			logResult("充值成功\n");
     		}
     	}
    }else{
    	
    }

  //   else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		// //判断该笔订单是否在商户网站中已经做过处理
		// 	//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		// 	//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
		// 	//如果有做过处理，不执行商户的业务程序
				
		// //注意：
		// //付款完成后，支付宝系统发送该交易状态通知

  //       //调试用，写文本函数记录程序运行情况是否正常
  //       //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
  //   }

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>