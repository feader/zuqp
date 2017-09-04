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
if($_GET['action'] == 'search' ){

	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and uid = '$uid'";
	}
	if(!empty($_GET['handler'])){
		$handler = $_GET['handler'];
		$where .= " and handler = '$handler'";
	}
	
}

if(!empty($_GET['id'])){
	$id = $_GET['id'];
	$sql_detail = "select * from t_user_complain where id = $id";
	$detail_info = $db->get_one_info($sql_detail);
	$smarty->assign("detail_info", $detail_info);
}

if($_POST['action'] == 'edit_info'){
	$id = $_POST['id'];
	$data = array();	
	$data['call_back'] = $_POST['call_back'];
	$data['status'] = 1;
	$data['handler'] = $_SESSION['admin_user_name'];
	$data['update_time'] = time();
	$res = $db->update_data($data,'t_user_complain',"id = $id");
	if($res){
		$db->jump('回复完成！','user_complain.php');
	}else{
		$db->jump('回复失败！');
	}
}


if($_GET['action'] == 'do_execel'){

	$dateStart = strtotime($_GET['dateStart']);
	$dateEnd = strtotime($_GET['dateEnd']);
	$where .= 'where create_time BETWEEN '.$dateStart.' and '.$dateEnd;
	$date_time['datestart'] = date('Y-m-d',$dateStart);
	$date_time['dateend'] = date('Y-m-d',$dateEnd);
	if(!empty($_GET['uid'])){
		$uid = $_GET['uid'];
		$where .= " and uid = '$uid'";
	}
	if(!empty($_GET['handler'])){
		$handler = $_GET['handler'];
		$where .= " and handler = '$handler'";
	}
	$user_sql = "select * from t_user_complain $where ORDER BY create_time DESC";

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
		 	->setCellValue('B1', '玩家ID')    
		 	->setCellValue('C1', '联系方式')    
		 	->setCellValue('D1', '状态')    
		 	->setCellValue('E1', '内容')    
		 	->setCellValue('F1', '回复') 
		 	->setCellValue('G1', '处理人') 
		 	->setCellValue('H1', '创建时间')  
		 	->setCellValue('I1', '更新时间');  
	foreach ($user_list as $k => $v) {
		$num=$k+2;
	 	$objPHPExcel->setActiveSheetIndex(0)
	 	->setCellValue('A'.$num, $v['id'])    
	 	->setCellValue('B'.$num, $v['uid'])    
	 	->setCellValue('C'.$num, $v['contact_way'])    
	 	->setCellValue('D'.$num, $v['status']==1 ? '已回复' : '未回复')    
	 	->setCellValue('E'.$num, $v['content'])    
	 	->setCellValue('F'.$num, $v['call_back'])    
	 	->setCellValue('G'.$num, $v['handler'])    
	 	->setCellValue('H'.$num, date('Y-m-d',$v['create_time']))    
	 	->setCellValue('I'.$num, date('Y-m-d',$v['update_time']));    
	}							 

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('sheet1');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	$time_name =  '回复数据'.date('YmdHis',time()).'.xls';

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

$user_sql = "select * from t_user_complain $where ORDER BY create_time DESC LIMIT $begin, " . 100;

$user_list = $db->fetchAll($user_sql);
$sqlCount    = "select count(1) as count from t_user_complain $where ORDER BY create_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts      = $resultCount['count'];
$pageHTML    = getPages($page, $counts, 100);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("user_list", $user_list);
$smarty->assign("date_time", $date_time);
$smarty->assign("uid", $uid);
$smarty->assign("handler", $handler);


$smarty->display("module/game_manager/user_complain.html");