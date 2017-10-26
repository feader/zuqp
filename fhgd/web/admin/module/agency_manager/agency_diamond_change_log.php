<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db,$dbConfig;
$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$gid = $session_data['gid'];
//管理端的代理列表
$page  = getUrlParam('pid');
$begin = ($page - 1) * 10;


$date_time = array();
$date_time['datestart'] = date('Y-m-d',time());
$date_time['dateend'] = date('Y-m-d',time()+86400);


if($_GET['action'] == 'search' ){

	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['auid'])){
		$auid = $_GET['auid'];
		$where .= " and auid = '$auid'";
	}
	if(!empty($_GET['handler'])){
		$handler = $_GET['handler'];
		$where .= " and handler = '$handler'";
	}
	$input_data = array();
	$input_data['handler'] = $_GET['handler'];
	$input_data['auid'] = $_GET['auid'];
	
}

// if($_GET['action'] == 'do_execel'){

// 	$dateStart = strtotime($_GET['dateStart']);
// 	$dateEnd = strtotime($_GET['dateEnd']);
// 	$where .= 'where register_time BETWEEN '.$dateStart.' and '.$dateEnd;
// 	$date_time['datestart'] = date('Y-m-d',$dateStart);
// 	$date_time['dateend'] = date('Y-m-d',$dateEnd);
// 	if(!empty($_GET['uid'])){
// 		$uid = $_GET['uid'];
// 		$where .= " and uid = '$uid'";
// 	}
// 	if(!empty($_GET['uber_agency'])){
// 		$uber_agency = $_GET['uber_agency'];
// 		$where .= " and uber_agency = '$uber_agency'";
// 	}
// 	$user_sql = "select * from t_agency $where ORDER BY register_time DESC";

// 	$user_list = $db->fetchAll($user_sql);

// 	require_once dirname(__FILE__) . '/../../class/PHPExcel.php';

// 	$objPHPExcel = new PHPExcel();

// 	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
// 								 ->setLastModifiedBy("Maarten Balliauw")
// 								 ->setTitle("Office 2007 XLSX Test Document")
// 								 ->setSubject("Office 2007 XLSX Test Document")
// 								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
// 								 ->setKeywords("office 2007 openxml php")
// 								 ->setCategory("Test result file");
// 	$objPHPExcel->setActiveSheetIndex(0)
// 		 	->setCellValue('A1', '编号')    
// 		 	->setCellValue('B1', '代理ID')    
// 		 	->setCellValue('C1', '电话')    
// 		 	->setCellValue('D1', '代理等级')    
// 		 	->setCellValue('E1', '上级代理')    
// 		 	->setCellValue('F1', '呢称') 
// 		 	->setCellValue('G1', '充值钻石') 
// 		 	->setCellValue('H1', '充值金额')  
// 		 	->setCellValue('I1', '注册时间');  
// 	foreach ($user_list as $k => $v) {
// 		$num=$k+2;
// 	 	$objPHPExcel->setActiveSheetIndex(0)
// 	 	->setCellValue('A'.$num, $v['id'])    
// 	 	->setCellValue('B'.$num, $v['uid'])    
// 	 	->setCellValue('C'.$num, $v['phone_number'].' ')    
// 	 	->setCellValue('D'.$num, $v['grade'])    
// 	 	->setCellValue('E'.$num, $v['uber_agency'])    
// 	 	->setCellValue('F'.$num, $v['nick_name'])    
// 	 	->setCellValue('G'.$num, $v['recharge_dimond'])    
// 	 	->setCellValue('H'.$num, $v['recharge_money'])     
// 	 	->setCellValue('I'.$num, date('Y-m-d H:i:s',$v['register_time']));    
// 	}							 

// 	// Rename worksheet
// 	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

// 	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
// 	$objPHPExcel->setActiveSheetIndex(0);

// 	$time_name =  '代理数据'.date('YmdHis',time()).'.xls';

// 	// Redirect output to a client’s web browser (Excel5)
// 	header('Content-Type: application/vnd.ms-excel');
// 	header("Content-Disposition: attachment;filename='$time_name'");
// 	header('Cache-Control: max-age=0');
// 	// If you're serving to IE 9, then the following may be needed
// 	header('Cache-Control: max-age=1');

// 	// If you're serving to IE over SSL, then the following may be needed
// 	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
// 	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
// 	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
// 	header ('Pragma: public'); // HTTP/1.0

// 	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
// 	$objWriter->save('php://output');
// 	die;
// }

$sql = "select * from t_agency_diamond_change_log $where ORDER BY create_time DESC LIMIT $begin, " . 10;
$log_list = $db->fetchAll($sql);

$sqlCount    = "select count(1) as count from t_agency_diamond_change_log $where ORDER BY create_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 10);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("gid", $gid);
$smarty->assign("log_list", $log_list);
$smarty->assign("date_time", $date_time);
$smarty->assign("input_data", $input_data);
$smarty->display("module/agency_manager/agency_diamond_change_log.html");

