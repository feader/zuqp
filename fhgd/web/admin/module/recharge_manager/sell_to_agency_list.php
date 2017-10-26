<?php
header("Content-Type: text/html; charset=UTF-8");
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;


$page  = getUrlParam('pid');
$begin = ($page - 1) * 100;

$date_time = array();
$date_time['datestart'] = date('Y-m-d',time());
$date_time['dateend'] = date('Y-m-d',time()+86400);

$where = '';
$dateStart = strtotime($date_time['datestart']);
$dateEnd = strtotime($date_time['dateend']);
$where = 'where create_time BETWEEN '.$dateStart.' and '.$dateEnd;

$gm_charge_sql = "SELECT sell_agency_uid,sum(dimond_num) as total_diamond FROM `t_agency_sell_to_agency` WHERE sell_agency_uid in('') and create_time between 0 and $dateEnd group by sell_agency_uid";

if($_GET['action'] == 'search' ){
	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where = 'where create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['sell_agency_uid'])){
		$sell_agency_uid = $_GET['sell_agency_uid'];
		$where .= " and sell_agency_uid = '$sell_agency_uid'";
	}	
	if(!empty($_GET['buy_agency_uid'])){
		$buy_agency_uid = $_GET['buy_agency_uid'];
		$where .= " and buy_agency_uid = '$buy_agency_uid'";
	}	
	$input_data = array();
	$input_data['sell_agency_uid'] = $sell_agency_uid;
	$input_data['buy_agency_uid'] = $buy_agency_uid;
	$gm_charge_sql = "SELECT sell_agency_uid,sum(dimond_num) as total_diamond FROM `t_agency_sell_to_agency` WHERE sell_agency_uid in('') and create_time between $dateStart and $dateEnd group by sell_agency_uid";
}

$gm_charge_log = $db->fetchAll($gm_charge_sql);

if($_GET['action'] == 'do_execel'){
	$where = '';
	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['sell_agency_uid'])){
		$sell_agency_uid = $_GET['sell_agency_uid'];
		$where .= " and sell_agency_uid = '$sell_agency_uid'";
	}	
	if(!empty($_GET['buy_agency_uid'])){
		$buy_agency_uid = $_GET['buy_agency_uid'];
		$where .= " and buy_agency_uid = '$buy_agency_uid'";
	}	
	
	$user_sql = "select * from t_agency_sell_to_agency $where ORDER BY create_time DESC";

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
		 	->setCellValue('C1', '购买代理ID')    
		 	->setCellValue('D1', '钻石数量')    
		 	->setCellValue('E1', '出售时间');    
		 	
	foreach ($user_list as $k => $v) {
		$num=$k+2;
	 	$objPHPExcel->setActiveSheetIndex(0)
	 	->setCellValue('A'.$num, $v['id'])    
	 	->setCellValue('B'.$num, $v['sell_agency_uid'])    
	 	->setCellValue('C'.$num, $v['buy_agency_uid'])    
	 	->setCellValue('D'.$num, $v['dimond_num']) 
	 	->setCellValue('E'.$num, date('Y-m-d H:i:s',$v['create_time']));    
	}							 

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$time_name =  '上级代理出售钻石明细'.date('YmdHis',time()).'.xls';

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
$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y')); 
$endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
$lastweek = get_count($beginLastweek,$endLastweek,'lastweek',$db);

$user_sql = "select * from t_agency_sell_to_agency $where ORDER BY create_time DESC LIMIT $begin, " . 100;
$user_list = $db->fetchAll($user_sql);
$sqlCount    = "select count(*) as count from t_agency_sell_to_agency $where ORDER BY create_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 100);

$search_sql = "SELECT sum(dimond_num) AS all_dimond FROM t_agency_sell_to_agency $where";
$search_dimond = $db->get_one_info($search_sql);

$all_dimond_sql = "SELECT sum(dimond_num) AS all_dimond FROM t_agency_sell_to_agency";
$all_dimond = $db->get_one_info($all_dimond_sql);

$total_data = array();
$total_data['today'] = $today;
$total_data['yesterday'] = $yesterday;
$total_data['lastweek'] = $lastweek;

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("user_list", $user_list);
$smarty->assign("gm_charge_log", $gm_charge_log);
$smarty->assign("date_time", $date_time);
$smarty->assign("input_data", $input_data);
$smarty->assign("total_data", $total_data);
$smarty->assign("all_dimond", $all_dimond['all_dimond'] ? $all_dimond['all_dimond'] : 0);
$smarty->assign("search_dimond", $search_dimond['all_dimond'] ? $search_dimond['all_dimond'] : 0);


$smarty->display("module/recharge_manager/sell_to_agency_list.html");

function get_count($start,$end,$name,$db){
	$data = array();
	$sql = "SELECT sum(dimond_num) AS $name FROM t_agency_sell_to_agency WHERE create_time between $start and $end";
	$data = $db->get_one_info($sql);
	return $data[$name] ? $data[$name] : 0;
}