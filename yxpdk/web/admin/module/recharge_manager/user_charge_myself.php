<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;

$page = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;
$where = '';
//充值订单
$action = trim($_GET['action']);

if ($action == 'set_condition') {

    $sql = "select * from t_user_charge_order ";

    $where .= " where 1 and finish_time is not null";
    if (!empty($_GET['trade_no'])) {
        $trade_no = $_GET['trade_no'];
        $where .= " AND trade_no = '$trade_no' ";
    }
    if (!empty($_GET['transaction_id'])) {
        $transaction_id = $_GET['transaction_id'];
        $where .= " AND transaction_id = '$transaction_id' ";
    }
    
    if (!empty($_GET['uid'])) {
        $uid = $_GET['uid'];
        $where .= " AND uid = '$uid' ";
    }
    
    if (!empty($_GET['dateStart'])) {
        $date_start = $_GET['dateStart'];
        $start_time = strtotime($date_start);
        $where .= " AND create_time >= $start_time ";
    }
    
    if (!empty($_GET['dateEnd'])) {
        $date_end = $_GET['dateEnd'];
        $end_time = strtotime($date_end);
        $where .= " AND create_time <= $end_time ";
    }

    $sql .= $where . " ORDER BY create_time DESC LIMIT $begin, " . LIST_PER_PAGE_RECORDS;
    
    $order_list = $db->fetchAll($sql);

    $data_time = array();
    $data_time['datestart'] = date('Y-m-d',$start_time);
    $data_time['dateend'] = date('Y-m-d',$end_time);

    $input_data = array();
    $input_data['trade_no'] = $trade_no;
    $input_data['uid'] = $uid;
    $input_data['transaction_id'] = $transaction_id;

    
}else{

    $sql = "select * from t_user_charge_order ";
    $sql .= $where . " ORDER BY create_time DESC LIMIT $begin, " . LIST_PER_PAGE_RECORDS;
    $order_list = $db->fetchAll($sql);


}

if($_GET['action'] == 'do_execel'){
    $where .= " where 1 and finish_time is not null";
    if (!empty($_GET['dateStart'])) {
        $date_start = $_GET['dateStart'];
        $start_time = strtotime($date_start);
        $where .= " AND create_time >= $start_time ";
    }
    
    if (!empty($_GET['dateEnd'])) {
        $date_end = $_GET['dateEnd'];
        $end_time = strtotime($date_end);
        $where .= " AND create_time <= $end_time ";
    }
    
    if (!empty($_GET['trade_no'])) {
        $trade_no = $_GET['trade_no'];
        $where .= " AND trade_no = '$trade_no' ";
    }
    if (!empty($_GET['transaction_id'])) {
        $transaction_id = $_GET['transaction_id'];
        $where .= " AND transaction_id = '$transaction_id' ";
    }
    
    if (!empty($_GET['uid'])) {
        $uid = $_GET['uid'];
        $where .= " AND uid = '$uid' ";
    }
    
    $user_sql = "select * from t_user_charge_order $where ORDER BY create_time DESC";

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
            ->setCellValue('C1', '订单号')    
            ->setCellValue('D1', '支付号')    
            ->setCellValue('E1', '金额')  
            ->setCellValue('F1', '房卡数')   
            ->setCellValue('G1', '订单创建时间')     
            ->setCellValue('H1', '订单完成时间')   
            ->setCellValue('I1', '状态');    
            
    foreach ($user_list as $k => $v) {
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$num, $v['id'])    
        ->setCellValue('B'.$num, $v['uid'])    
        ->setCellValue('C'.$num, $v['trade_no'].' ')    
        ->setCellValue('D'.$num, $v['transaction_id'].' ')    
        ->setCellValue('E'.$num, $v['price'])    
        ->setCellValue('F'.$num, $v['dimond'])    
        ->setCellValue('G'.$num, date('Y-m-d H:i:s',$v['create_time']))    
        ->setCellValue('H'.$num, $v['finish_time'] ? date('Y-m-d H:i:s',$v['finish_time']) : '无')    
        ->setCellValue('I'.$num, $v['status']==1 ? '已支付' : '未支付');    
    }  
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);                        
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);        
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);                        
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);                        

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('sheet1');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    $time_name =  '玩家自助充值明细'.date('YmdHis',time()).'.xls';

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

$sqlCount = "select count(1) as count from t_user_charge_order $where ORDER BY create_time DESC";

$resultCount = $db->fetchOne($sqlCount);
$counts = $resultCount['count'];
$pageHTML = getPages($page, $counts, LIST_PER_PAGE_RECORDS);

$smarty->assign("uid", $uid);
$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("order_list", $order_list);
$smarty->assign("data_time", $data_time);
$smarty->assign("input_data", $input_data);
$smarty->display("module/recharge_manager/user_charge_myself.html");


