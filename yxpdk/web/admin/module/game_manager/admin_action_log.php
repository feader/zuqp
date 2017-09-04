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
    // if (!empty($_REQUEST['uid'])) {
    //     $uid = SS($_REQUEST['uid']);
    // }

    // $smarty->assign("uid", $uid);
    // $smarty->display("module/recharge_manager/recharge_order_querry_condition.html");
// }else {
    $sql = "select * from t_ban_log ";

    $where .= " where 1";
    if (!empty($_GET['handler'])) {
        $handler = $_GET['handler'];
        $where .= " AND handler = '$handler' ";
    }
    if (!empty($_GET['content'])) {
        $content = $_GET['content'];
        $where .= " AND content = '$content' ";
    }
    
    if (!empty($_GET['uid'])) {
        $uid = $_GET['uid'];
        $where .= " AND uid = '$uid' ";
    }
    
    if (!empty($_GET['dateStart']) && $_GET['dateStart']!=0) {
        $date_start = $_GET['dateStart'];
        $start_time = strtotime($date_start);
        $where .= " AND action_time >= $start_time ";
    }
    
    if (!empty($_GET['dateEnd']) && $_GET['dateEnd']!=0) {
        $date_end = $_GET['dateEnd'];
        $end_time = strtotime($date_end);
        $where .= " AND action_time <= $end_time ";
    }

    $sql .= $where . " ORDER BY action_time DESC LIMIT $begin, " . LIST_PER_PAGE_RECORDS;
    
    $order_list = $db->fetchAll($sql);

    $data_time = array();
    $data_time['datestart'] = date('Y-m-d',$start_time);
    $data_time['dateend'] = date('Y-m-d',$end_time);

    $input_data = array();
    $input_data['handler'] = $handler;
    $input_data['uid'] = $uid;
    $input_data['content'] = $content;

    
}else{

    $sql = "select * from t_ban_log ";
    $sql .= $where . " ORDER BY action_time DESC LIMIT $begin, " . LIST_PER_PAGE_RECORDS;
    $order_list = $db->fetchAll($sql);


}

if($_GET['action'] == 'do_execel'){
    $where .= " where 1";
    if (!empty($_GET['dateStart'])) {
        $date_start = $_GET['dateStart'];
        $start_time = strtotime($date_start);
        $where .= " AND action_time >= $start_time ";
    }
    
    if (!empty($_GET['dateEnd'])) {
        $date_end = $_GET['dateEnd'];
        $end_time = strtotime($date_end);
        $where .= " AND action_time <= $end_time ";
    }
    
    if (!empty($_GET['handler'])) {
        $handler = $_GET['handler'];
        $where .= " AND handler = '$handler' ";
    }
    if (!empty($_GET['content'])) {
        $content = $_GET['content'];
        $where .= " AND content = '$content' ";
    }
    
    if (!empty($_GET['uid'])) {
        $uid = $_GET['uid'];
        $where .= " AND uid = '$uid' ";
    }
    
    $user_sql = "select * from t_ban_log $where ORDER BY action_time DESC";

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
            ->setCellValue('C1', '动作类型')    
            ->setCellValue('D1', '操作者')               
            ->setCellValue('E1', '动作描述')               
            ->setCellValue('F1', '订单完成时间');   

            
    foreach ($user_list as $k => $v) {
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$num, $v['id'])    
        ->setCellValue('B'.$num, $v['uid'])    
        //->setCellValue('C'.$num, $v['action_type'] ==0 ? '默认' : $v['action_type'] ==1 : '封禁' : '解封')    
        ->setCellValue('C'.$num, $v['action_type'])    
        ->setCellValue('D'.$num, $v['handler'])    
        ->setCellValue('E'.$num, $v['content'])    
        ->setCellValue('F'.$num, date('Y-m-d H:i:s',$v['action_time']));             
    }                            

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('sheet1');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    $time_name =  '操作日志'.date('YmdHis',time()).'.xls';

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

$sqlCount = "select count(*) as count from t_ban_log $where ORDER BY action_time DESC";
$resultCount = $db->fetchOne($sqlCount);
$counts = $resultCount['count'];
$pageHTML = getPages($page, $counts, LIST_PER_PAGE_RECORDS);

$smarty->assign("uid", $uid);
$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("order_list", $order_list);
$smarty->assign("data_time", $data_time);
$smarty->assign("input_data", $input_data);
$smarty->display("module/game_manager/admin_action_log.html");


