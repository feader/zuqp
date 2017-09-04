<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

//管理端添加代理
$action = SS($_REQUEST['action']);

if ($action == 'generate') {
	$grade = SS($_REQUEST['grade']);
	$uberAgency = SS($_REQUEST['uberAgency']);

	$cnt1 = generate_password();

	$cnt = check($cnt1,$db);

	// $sql_cnt = "select max(id) as count from t_agency "; //where grade = " . $grade;
	// $result = $db->fetchOne($sql_cnt);
	// $cnt0 = $result['count'] + 1;
	// $cnt = sprintf('%04s', $cnt0);

	if ($grade == '1') {
		$uid = 'hg' . $cnt;
	} else if ($grade == '2') {
		$uid = 'zs' . $cnt;	
		$check = $db->get_one_info("select grade from t_agency where uid='$uberAgency'");
		if(!$check || $check['grade']!=1){
			$result = array('result' => "failed");
			echo json_encode($result);
			die;
		}	
	} else if ($grade == '3') {
		$uid = 'bj' . $cnt;
		$check = $db->get_one_info("select grade from t_agency where uid='$uberAgency'");
		if(!$check || $check['grade']!=2){
			$result = array('result' => "failed");
			echo json_encode($result);
			die;
		}		
	}else if($grade == '4'){
		$uid = 'sj' . $cnt;			
	}
 
	$password = password();
	$now = time();

	
	
	$sql = "INSERT INTO t_agency (uid, `password`, grade, uber_agency, register_time)"
			. "VALUES ('$uid', '$password', $grade, '$uberAgency', $now);";
	$result = $db->query($sql);


	if (!empty($result)) {
		$result = array('name' => $uid, 'password' => $password);
		echo json_encode($result);
	} else {
		echo array('result' => "failed");
	}
	die();
}

$smarty->display("module/agency_manager/generate_agency.html");


function password() {
	$str = "0123456789";
	$s = "";
	for ($i=0; $i<8; $i++) {
		$s .= $str[rand(0, 9)];
	}
	return strtolower($s);
}

function generate_password($length=4) { 
	// 密码字符集，可任意添加你需要的字符 
	$chars = '0123456789'; 
	$password =''; 
	for ( $i = 0; $i < $length; $i++ ) { 
		// 这里提供两种字符获取方式 
		// 第一种是使用 substr 截取$chars中的任意一位字符； 
		// 第二种是取字符数组 $chars 的任意元素 
		// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
		$password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
	} 
	return $password; 
} 

function check($str,$db){
	$sql = "select uid from t_agency where uid like '@$str@'";
	$check = $db->get_one_info($sql);
	if(!$check){
		return $str;
	}else{
		$str1 = generate_password();
		check($str1,$db);
	}
}