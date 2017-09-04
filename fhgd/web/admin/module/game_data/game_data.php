<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

$select_time = SS($_REQUEST['select_time']);
if (empty($select_time)) {
    $select_time = "one_day";
}

$date_time = array();
$date_time['datestart'] = date('Y-m-d',time());
$date_time['dateend'] = date('Y-m-d',time()+86400);

$todayTime = strtotime(date("Y-m-d"));
$tomorrow = strtotime(date("Y-m-d"))+86400-1;

//注册人数
$register_num_sql = "select count(*) as count from t_game_user";
$register_num_total = $db->get_one_info($register_num_sql);

$now = time();
$time_range_left = $now - get_select_time($select_time);

$month = date('m',$now);
$year = date('Y',$now);
$day = date('d',$now);
$hour = date('H',$now);

//当前在线人数
// $sql_curr_online = 'SELECT online FROM `t_online_log` '
//      . ' where dateline = '
//         . ' ( select max( dateline ) from t_online_log ) '
//         . ' group by dateline LIMIT 0, 30 ';

$sql_curr_online = "select online from t_online_log order by `dateline` DESC";

$now_online = $db->get_one_info($sql_curr_online);


//今天在线数据
// $sql_range_time = "select online, dateline from ".T_LOG_ONLINE
//  ." where dateline > $time_range_left and dateline < $now order by dateline asc";
$sql_range_time = "select online, dateline from `t_online_log` where dateline between $todayTime and $tomorrow order by dateline asc";    

$today_result = $db->fetchAll($sql_range_time);
$today_data = '';
$flag = false;
foreach($today_result as $key=>$row)
{
    if($flag) $today_data .= ',';
    $tmp = '[Date.UTC(' . strftime("%Y,%m,%d,%H,%M,%S", $row['dateline']) . '),' .$row['online'].']';
    $today_data .= $tmp;
    $flag = true;
}

$today_str = strftime("%Y-%m-%d", time());


$y = date("Y");
$m = date("m");
$d = date("d");

if($_GET['action'] == 'do_execel'){
    $where = '';
    $dateStart = strtotime($_GET['dateStart']);
    $dateEnd = strtotime($_GET['dateEnd']);
    $where .= 'where dateline BETWEEN '.$dateStart.' and '.$dateEnd;
    $date_time['datestart'] = date('Y-m-d',$dateStart);
    $date_time['dateend'] = date('Y-m-d',$dateEnd);
    
    
    $user_sql = "select id,online, dateline from `t_online_log` $where order by dateline asc";

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
            ->setCellValue('B1', '在线人数')             
            ->setCellValue('C1', '记录时间');    
            
    foreach ($user_list as $k => $v) {
        $num=$k+2;
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$num, $v['id'])    
        ->setCellValue('B'.$num, $v['online'])    
        ->setCellValue('C'.$num, date('Y-m-d H:i:s',$v['dateline']));    
    }                            
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('sheet1');

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    $time_name =  '在线人数'.date('YmdHis',time()).'.xls';

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

//今天消耗的钻石
$today_cost_dimond_sql = "select sum(use_dimond) as total from t_user_dimond_log where use_time between $todayTime and $tomorrow";
$today_cost_dimond = $db->get_one_info($today_cost_dimond_sql);

//总消耗的钻石
$all_cost_dimond_sql = "select sum(use_dimond) as total from t_user_dimond_log";
$all_cost_dimond = $db->get_one_info($all_cost_dimond_sql);

//总销售的钻石
$all_sell_dimond_sql = "select sum(dimond_num) as total from t_sell_log";
$all_sell_dimond = $db->get_one_info($all_sell_dimond_sql);

$smarty->assign("select_time", $select_time);
$smarty->assign("today_str", $today_str);
$smarty->assign("today_data", $today_data);
$smarty->assign("register_num_total", $register_num_total['count']);
$smarty->assign("today_cost_dimond", intval($today_cost_dimond['total']));
$smarty->assign("all_cost_dimond", intval($all_cost_dimond['total']));
$smarty->assign("all_sell_dimond", intval($all_sell_dimond['total']));
$smarty->assign("now_online", $now_online['online']);
$smarty->assign("date_time", $date_time);
$smarty->display("module/game_data/game_data.html");


function get_select_time($select_time)
{
    $time_range = 0;
    switch ($select_time) {
        case "one_hour":
            $time_range = 3600;
            break;
        case "six_hour":
            $time_range = 21600;
            break;
        case "one_day":
            $time_range = 86400;
            break;
        case "one_week":
            $time_range = 604800;
            break;
        case "one_month":
            $time_range = 2592000;
            break;
        case "three_month":
            $time_range = 7776000;
            break;
        case "six_month":
            $time_range = 15552000;
            break;
        case "one_year":
            $time_range = 31536000;
            break;
        default:
            break;
    }

    return $time_range;
}
