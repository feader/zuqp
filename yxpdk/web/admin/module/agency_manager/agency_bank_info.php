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

$where = 'where 1';

if($_GET['action'] == 'search' ){

	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and uid = '$uid'";
	}
	$input_data = array();
	$input_data['uid'] = $uid;
	
}

if($_GET['action'] == 'do_execel'){

	
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and uid = '$uid'";
	}
	
	$user_sql = "select * from t_agency_bank_info $where";

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
		 	->setCellValue('A1', '编号')    
		 	->setCellValue('B1', '代理ID')    
		 	->setCellValue('C1', '微信')    
		 	->setCellValue('D1', '支付宝')    
		 	->setCellValue('E1', '开户行')    
		 	->setCellValue('F1', '分行') 
		 	->setCellValue('G1', '开户名') 
		 	->setCellValue('H1', '开户账号');  		 	
	foreach ($user_list as $k => $v) {
		$num=$k+2;
	 	$objPHPExcel->setActiveSheetIndex(0)
	 	->setCellValue('A'.$num, $v['id'])    
	 	->setCellValue('B'.$num, $v['uid'])    
	 	->setCellValue('C'.$num, $v['weixin'])    
	 	->setCellValue('D'.$num, $v['alipay'])    
	 	->setCellValue('E'.$num, $v['opening_bank'])    
	 	->setCellValue('F'.$num, $v['branch'])    
	 	->setCellValue('G'.$num, $v['bank_name'])    
	 	->setCellValue('H'.$num, $v['bank_account']);     	 	
	}							 

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$time_name =  '代理银行资料'.date('YmdHis',time()).'.xls';

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

$sql = "select * from t_agency_bank_info $where LIMIT $begin, " . 10;
$agency_bank_info_list = $db->fetchAll($sql);

$sqlCount    = "select count(1) as count from t_agency_bank_info $where";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 10);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("gid", $gid);
$smarty->assign("agency_bank_info_list", $agency_bank_info_list);
$smarty->assign("input_data", $input_data);
$smarty->display("module/agency_manager/agency_bank_info.html");
