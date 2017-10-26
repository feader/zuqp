<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN . '/include/global.php';
global $smarty, $db;

$page = getUrlParam('pid');
$begin = ($page - 1) * 20;
$where = '';
//充值订单
$action = trim($_GET['action']);

if ($action == 'set_condition') {

    $sql = "select * from t_recharge_log ";

    $where .= " where 1";
    if (!empty($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $where .= " AND order_id = '$order_id' ";
    }
    if (!empty($_GET['alipay_order_id'])) {
        $alipay_order_id = $_GET['alipay_order_id'];
        $where .= " AND alipay_order_id = '$alipay_order_id' ";
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
    }else{
        $end_time = strtotime(date('Y-m-d',time()+86400));
    }

    $status = $_GET['status'];
    $where1 = '';

    switch ($status) {
        case '0':
            $where1 .= $where.' AND order_status = 1';
            $where .= " AND order_status = '$status' ";
            break;
        case '1':         
            $where .= " AND order_status = '$status' ";
            $where1 .= $where;
            break;
        case '1':
            $where1 .= $where.' AND order_status = 1';
            $where .= '';
            break;    
        default:
            $where1 .= $where.' AND order_status = 1';  
            $where .= '';
            break;
    }

    $sql .= $where . " ORDER BY order_status desc,create_time DESC LIMIT $begin,20";

    $order_list = $db->fetchAll($sql);

    $search_charge_sql = "select sum(money_number) as total_money from t_recharge_log $where1";
    $search_charge = $db->fetchOne($search_charge_sql);

    $input_data = array();
    $input_data['order_id'] = $order_id;
    $input_data['uid'] = $uid;
    $input_data['alipay_order_id'] = $alipay_order_id;
    $input_data['status'] = $_GET['status'];
    $input_data['datestart'] = date('Y-m-d',$start_time);
    $input_data['dateend'] = date('Y-m-d',$end_time);
  
}else{

    $sql = "select * from t_recharge_log ";
    $sql .= $where . " ORDER BY order_status desc,create_time DESC LIMIT $begin,20";
    $order_list = $db->fetchAll($sql);


}

if($_GET['action'] == 'do_execel'){
    $where .= " where 1";
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
    
    if (!empty($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $where .= " AND order_id = '$order_id' ";
    }
    if (!empty($_GET['alipay_order_id'])) {
        $alipay_order_id = $_GET['alipay_order_id'];
        $where .= " AND alipay_order_id = '$alipay_order_id' ";
    }
    
    if (!empty($_GET['uid'])) {
        $uid = $_GET['uid'];
        $where .= " AND uid = '$uid' ";
    }
    
    $user_sql = "select * from t_recharge_log $where order_status desc,ORDER BY create_time DESC";

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
            ->setCellValue('F1', '钻石')   
            ->setCellValue('G1', '订单创建时间')   
            ->setCellValue('H1', '订单成功时间')   
            ->setCellValue('I1', '订单完成时间')   
            ->setCellValue('J1', '状态');    
            
    foreach ($user_list as $k => $v) {
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$num, $v['id'])    
        ->setCellValue('B'.$num, $v['uid'])    
        ->setCellValue('C'.$num, $v['order_id'].' ')    
        ->setCellValue('D'.$num, $v['alipay_order_id'].' ')    
        ->setCellValue('E'.$num, $v['money_number'])    
        ->setCellValue('F'.$num, $v['dimond_number'])    
        ->setCellValue('G'.$num, date('Y-m-d H:i:s',$v['create_time']))    
        ->setCellValue('H'.$num, $v['success_time'] ? date('Y-m-d H:i:s',$v['success_time']) : '无')    
        ->setCellValue('I'.$num, $v['finish_time'] ? date('Y-m-d H:i:s',$v['finish_time']) : '无')    
        ->setCellValue('J'.$num, $v['order_status']==1 ? '已支付' : '未支付');    
    }                            

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('sheet1');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    $time_name =  '代理充值明细'.date('YmdHis',time()).'.xls';

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

$total_charge_sql = "select sum(money_number) as total_money from t_recharge_log where order_status =1";
$total_charge = $db->fetchOne($total_charge_sql);

$sqlCount = "select count(1) as count from t_recharge_log $where ORDER BY order_status desc,action_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts = $resultCount['count'];
$pageHTML = getPages($page, $counts, 20);

$smarty->assign("uid", $uid);
$smarty->assign("total_charge", $total_charge['total_money']/100);
$smarty->assign("search_charge", $search_charge['total_money']/100);
$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("order_list", $order_list);
$smarty->assign("data_time", $data_time);
$smarty->assign("input_data", $input_data);
$smarty->display("module/recharge_manager/recharge_order_list.html");


