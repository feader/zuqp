<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;
//查询钻石消耗记录
if($_GET['action']=='search'){
    
    $post = array();    
    
    foreach ($_GET as $key => $value) {
        
        $post[$key] = $db->check_input($value);
    
    }
    
    switch ($post['sort']) {
        case '1':
            $order = 'order by write_time desc';
            break;
        case '2':
            $order = 'order by write_time asc';
            break;
        case '3':
            $order = 'order by today_total_dimond desc';
            break;
        case '4':
            $order = 'order by today_total_dimond asc';
            break;
        
        default:
            $order = '';
            break;
    }
    
    $start = strtotime(str_replace("'","",$post['dateStart']));
    $end = strtotime(str_replace("'","",$post['dateEnd']));
        
    
    $sql ="select * from t_everyday_total_dimond_log where write_time between '$start' and '$end' $order LIMIT 0,365";
    // $sqlCount    = "select count(1) as count from t_recharge_log";
    // $resultCount = $db->fetchOne($sqlCount);
    // $counts      = $resultCount['count'];
    // $pageHTML    = getPages($page, $counts, LIST_PER_PAGE_RECORDS);
    $recharge_log_list = $db->fetchAll($sql); 

    foreach ($recharge_log_list as $key => $value) {
        $total += $value['today_total_dimond'];
    }

    $date_time = array();
    $date_time['start'] = date('Y-m-d', $start);
    $date_time['end'] = date('Y-m-d', $end);

    $smarty->assign("recharge_log_list", $recharge_log_list);
    $smarty->assign("total", $total);
    $pageHTML    = getPages($page, $counts, LIST_PER_PAGE_RECORDS);
    $smarty->assign("pageHTML", $pageHTML);
    $smarty->assign("date_time", $date_time);
}

$all_money_sql ="select sum(today_total_dimond) as all_money from t_everyday_total_dimond_log";
$all_money = $db->get_one_info($all_money_sql); 
$smarty->assign("all_money", $all_money['all_money']);


$smarty->display("module/recharge_manager/recharge_order_query.html");