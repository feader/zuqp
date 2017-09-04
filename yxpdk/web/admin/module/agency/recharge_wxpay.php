<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global2.php';
global $smarty, $db;


//定时查询订单状态，返回是否完成支付
if($_GET['action']=='get_order_res'){
	$order_id = SS($_GET['order_id']);
	$sql = "select * from t_recharge_log where order_id='$order_id' and pay_way='wxpay'";
	$res = $db->get_one_info($sql);
	if($res['order_status']==1){
		echo json_encode(1);
	}else{
		echo json_decode(0);
	}
	die;
}
die;

