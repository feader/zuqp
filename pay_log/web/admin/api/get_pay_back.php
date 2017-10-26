<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

$secret ="c921727526477ed9db4e06bd583573f6"; // 在产品申请单中填入的通知加密字符
    
// 下列各参数都不需要调用 urldecode 进行解码
$amount = $_GET['amount'];
$apporder = $_GET['apporder'];
$sdkorder = $_GET['sdkorder'];
$sign = $_GET['sign']; // 小写字符
$success = $_GET['success'];
$ts = $_GET['ts'];
$userdata = $_GET['userdata'];
$real_amount = $_GET['real_amount']; // 实际金额, 添加于 2017年5月8日
$sign2 = $_GET['sign2'];// 小写字符
$test = $_GET['test'];
// 组合加密列子
$str = $apporder.$sdkorder.$amount.$success.$ts.$secret;
//$str = $apporder.$sdkorder.$amount.$success.$ts.$secret.$real_amount;

// string for sign2
$str_2 = $str.$real_amount;
// $str_2 = $str;
$md5_str = md5($str); // 不要转换为大写
$md5_str2 = md5($str_2);// 不要转换为大写

$succ = "success"; // 正确处理完逻辑后必须返回 'success'. 其他字符将被认为处理失败
$fail = "fail";
// var_dump($str);
// var_dump($str_2);
// var_dump($sign2);
// var_dump($md5_str2);
// die;
// 验证 sign2 即可, sign 是为了兼容而没有删除的， 5月8日后不需要验证 sign 了
if ($sign2 == $md5_str2){
    // 处理业务逻辑,
    $check_sql = "select * from t_pay_info_log where apporder = '$apporder' and sdkorder = '$sdkorder'";

	$check = $db->get_one_info($check_sql);
    
	if(!$check){

		$data = array();

		$data['amount'] = $amount;
		
		$data['real_amount'] = $real_amount;
		
		$data['apporder'] = $apporder;
			
		$data['sdkorder'] = $sdkorder;
		
		$data['sign'] = $sign;

		$data['sign2'] = $sign2;
		
		$data['success'] = $success;
		
		$data['ts'] = $ts;
		
		$data['userdata'] = $userdata;
		
		$data['test'] = $test;
		
		$data['create_time'] = time();

		$res = $db->insert_data($data,'t_pay_info_log');

	}else{
		
		$res = 0;
	
	}

    if($res){
       
        echo $succ; 
    
    }else{
        
        echo $fail;
    
    }

}else{
	   
	echo $fail;

}

$log_data = array(	
	'text_conent' => '?amount='.$amount.'&real_amount='.$real_amount.'&apporder='.$apporder.'&sdkorder='.$sdkorder.'&sign='.$sign.'&sign2='.$sign2.'&success='.$success.'&ts='.$ts.'&userdata='.$userdata.'&test='.$test.'&create_time='.time(),		
);

$lot_res = $db->insert_data($log_data,'t_test_log'); 

die;