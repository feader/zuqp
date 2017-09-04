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

$where = '';
$dateStart = strtotime($date_time['datestart']);
$dateEnd = strtotime($date_time['dateend']);
$where = 'where action_time BETWEEN '.$dateStart.' and '.$dateEnd;

if($_GET['action'] == 'search' ){
	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where = 'where action_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['seller_uid'])){
		$seller_uid = $_GET['seller_uid'];
		$where .= " and seller_uid = '$seller_uid'";
	}	
	if(!empty($_GET['buyer_uid'])){
		$buyer_uid = $_GET['buyer_uid'];
		$where .= " and buyer_uid = '$buyer_uid'";
	}	
	$input_data = array();
	$input_data['seller_uid'] = $seller_uid;
	$input_data['buyer_uid'] = $buyer_uid;

}




if($_GET['action'] == 'do_execel'){

	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where action_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['seller_uid'])){
		$seller_uid = $_GET['seller_uid'];
		$where .= " and seller_uid = '$seller_uid'";
	}	
	if(!empty($_GET['buyer_uid'])){
		$buyer_uid = $_GET['buyer_uid'];
		$where .= " and buyer_uid = '$buyer_uid'";
	}	
	
	$user_sql = "select * from t_sell_log $where ORDER BY action_time DESC";

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
		 	->setCellValue('B1', '出售代理ID')    
		 	->setCellValue('C1', '购买玩家ID')    
		 	->setCellValue('D1', '玩家名')    
		 	->setCellValue('E1', '钻石数量')    
		 	->setCellValue('F1', '出售时间');    
		 	
	foreach ($user_list as $k => $v) {
		$num=$k+2;
	 	$objPHPExcel->setActiveSheetIndex(0)
	 	->setCellValue('A'.$num, $v['id'])    
	 	->setCellValue('B'.$num, $v['seller_uid'])    
	 	->setCellValue('C'.$num, $v['buyer_uid'])    
	 	->setCellValue('D'.$num, $v['buyer_name'])    
	 	->setCellValue('E'.$num, $v['dimond_num']) 
	 	->setCellValue('F'.$num, date('Y-m-d H:i:s',$v['action_time']));    
	}							 
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$time_name =  '玩家购买钻石明细'.date('YmdHis',time()).'.xls';

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

//今天代理给玩家售卡数
$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
$endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
$today = get_count($beginToday,$endToday,'today',$db);

//昨天代理给玩家售卡数
$beginYesterday = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
$endYesterday = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
$yesterday = get_count($beginYesterday,$endYesterday,'yesterday',$db);

//上周代理给玩家售卡数
$beginLastweek = mktime(0,0,0,date('m'),date('d')-7,date('Y'));
$endLastweek = mktime(23,59,59,date('m'),date('d')-1,date('Y'))-1;
$lastweek = get_count($beginLastweek,$endLastweek,'lastweek',$db);

$user_sql = "select * from t_sell_log $where ORDER BY action_time DESC LIMIT $begin, " . 100;
$user_list = $db->fetchAll($user_sql);
$sqlCount    = "select count(*) as count from t_sell_log $where ORDER BY action_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 100);

$all_dimond_sql = "SELECT sum(dimond_num) AS all_dimond FROM t_sell_log";
$all_dimond = $db->get_one_info($all_dimond_sql);

$total_data = array();
$total_data['today'] = $today;
$total_data['yesterday'] = $yesterday;
$total_data['lastweek'] = $lastweek;

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("user_list", $user_list);
$smarty->assign("date_time", $date_time);
$smarty->assign("input_data", $input_data);
$smarty->assign("total_data", $total_data);
$smarty->assign("all_dimond", $all_dimond['all_dimond'] ? $all_dimond['all_dimond'] : 0);


$smarty->display("module/recharge_manager/sell_to_user_list.html");

function get_count($start,$end,$name,$db){
	$data = array();
	$sql = "SELECT sum(dimond_num) AS $name FROM t_sell_log WHERE action_time between $start and $end";
	$data = $db->get_one_info($sql);
	return $data[$name] ? $data[$name] : 0;
}