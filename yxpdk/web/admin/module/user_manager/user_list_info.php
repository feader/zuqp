<?php
header("Content-Type: text/html; charset=UTF-8");
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;


$page  = getUrlParam('pid');
$begin = ($page - 1) * 100;

$date_time = array();
$date_time['datestart'] = date('Y-m-d',time()-86400);
$date_time['dateend'] = date('Y-m-d',time());

$where = 'where 1 ';
if($_GET['action'] == 'search' ){
	
	if(!empty($_GET['dateStart']) && !empty($_GET['dateEnd'])){
		$dateStart = strtotime($_GET['dateStart']);
		$dateEnd = strtotime($_GET['dateEnd']);
		$where .= 'and register_time BETWEEN '.$dateStart.' and '.$dateEnd;
		$date_time['datestart'] = date('Y-m-d',$dateStart);
		$date_time['dateend'] = date('Y-m-d',$dateEnd);
	}
	
	if(!empty($_GET['username'])){
		$username = $_GET['username'];
		$where .= " and username = '$username'";
	}
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and uid = '$uid'";
	}
	// if(!empty($_GET['total_pay_times'])){
	// 	$total_pay_times = $_GET['total_pay_times'];
	// 	$where .= " and total_pay_times = '$total_pay_times'";
	// }
}

if($_GET['action'] == 'do_execel'){
	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where register_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['username'])){
		$username = $_GET['username'];
		$where .= " and username = '$username'";
	}
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and uid = '$uid'";
	}
	if(!empty($_GET['total_pay_times'])){
		$total_pay_times = $_GET['total_pay_times'];
		$where .= " and total_pay_times = '$total_pay_times'";
	}
	$user_sql = "select * from t_game_user $where ORDER BY register_time DESC";
	$user_list = $db->fetchAll($user_sql);

	require_once dirname(__FILE__) . '/../../class/PHPExcel.php';

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)
		 	->setCellValue('A1', '玩家ID')    
		 	->setCellValue('B1', '呢称')    
		 	->setCellValue('C1', '注册日期')    
		 	->setCellValue('D1', '最后登录日期')    
		 	->setCellValue('E1', '钻石余额')    
		 	->setCellValue('F1', '总充值钻石')
		 	->setCellValue('G1', 'unionid');  
	foreach ($user_list as $k => $v) {
		$num=$k+2;
	 	$objPHPExcel->setActiveSheetIndex(0)
	 	->setCellValue('A'.$num, $v['uid'])    
	 	->setCellValue('B'.$num, $v['username'])    
	 	->setCellValue('C'.$num, date('Y-m-d',$v['register_time']))    
	 	->setCellValue('D'.$num, date('Y-m-d',$v['last_login_time']))    
	 	->setCellValue('E'.$num, $v['dimond'])    
	 	->setCellValue('F'.$num, $v['sum_dimond'])
	 	->setCellValue('G'.$num, $v['unionid']);    
	}							 

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$time_name =  '玩家数据'.date('YmdHis',time()).'.xls';

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename='$time_name'");
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	die;
}

$user_sql = "select * from t_game_user $where ORDER BY register_time DESC LIMIT $begin, " . 100;


$user_list = $db->fetchAll($user_sql);
$sqlCount    = "select count(1) as count from t_game_user $where ORDER BY register_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 100);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("user_list", $user_list);
$smarty->assign("date_time", $date_time);
$smarty->assign("username", $_GET['username']);
$smarty->assign("uid", $_GET['uid']);


$smarty->display("module/user_manager/user_list_info.html");