<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;
//管理端的代理列表
$page  = getUrlParam('pid');
$begin = ($page - 1) * 10;


$date_time = array();
$date_time['datestart'] = date('Y-m-d',time());
$date_time['dateend'] = date('Y-m-d',time()+86400);


if($_GET['action'] == 'search' ){

	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where o.create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and o.uid = '$uid'";
	}
	if(!empty($_GET['username'])){
		$username = $_GET['username'];
		$where .= " and u.username = '$username'";
	}
	
	$input_data = array();
	$input_data['username'] = $_GET['username'];
	$input_data['uid'] = $_GET['uid'];
	
}

if($_GET['action'] == 'do_execel'){

	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where o.create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and o.uid = '$uid'";
	}
	if(!empty($_GET['username'])){
		$username = $_GET['username'];
		$where .= " and u.username = '$username'";
	}
	$user_sql = "select o.id,o.uid,o.unionid,o.create_time,o.sign,o.sign_sort,o.sign_time,u.username from t_offline_play as o left join t_game_user as u on o.uid=u.uid $where ORDER BY o.create_time DESC";

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
		 	->setCellValue('B1', '玩家uid')    
		 	->setCellValue('C1', '玩家名')    
		 	->setCellValue('D1', '签到')    
		 	->setCellValue('E1', '签到序号')    
		 	->setCellValue('F1', '签到时间') 
		 	->setCellValue('G1', '报名时间') ;  
	foreach ($user_list as $k => $v) {
		$num=$k+2;
	 	$objPHPExcel->setActiveSheetIndex(0)
	 	->setCellValue('A'.$num, $k+1)    
	 	->setCellValue('B'.$num, $v['uid'])    
	 	->setCellValue('C'.$num, $v['username'])    
	 	->setCellValue('D'.$num, $v['sign'])    
	 	->setCellValue('E'.$num, $v['sign_sort'])    
	 	->setCellValue('F'.$num, date('Y-m-d H:i:s',$v['sign_time']))    
	 	->setCellValue('G'.$num, date('Y-m-d H:i:s',$v['create_time']));    
	}							 

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$time_name =  '线下赛玩家列表'.date('YmdHis',time()).'.xls';

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

$sql = "select o.id,o.uid,o.unionid,o.create_time,o.sign,o.sign_sort,o.sign_time,u.username from t_offline_play as o left join t_game_user as u on o.uid=u.uid $where ORDER BY o.create_time DESC LIMIT $begin, " . 10;

$player_list = $db->fetchAll($sql);

$sqlCount    = "select count(1) as count from t_offline_play as o left join t_game_user as u on o.uid=u.uid $where ORDER BY o.create_time DESC";

$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 10);

$smarty->assign("pageHTML", $pageHTML);

$smarty->assign("player_list", $player_list);
$smarty->assign("date_time", $date_time);
$smarty->assign("input_data", $input_data);
$smarty->display("module/game_manager/offline_player_list.html");

