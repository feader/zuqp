<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

$page  = getUrlParam('pid');
$begin = ($page - 1) * LIST_PER_PAGE_RECORDS;

$where = 'where 1 ';

$input_data = array();

if(!empty($_GET)){
    
    $dateStart = strtotime($_GET['dateStart']);
    
    $dateEnd = strtotime($_GET['dateEnd']);
    
    if($dateStart!='' && $dateEnd!=''){
        
        $where .= "and create_time between '$dateStart' and '$dateEnd'";
   
    }
    
    if($_GET['apporder']){
        
        $apporder = $_GET['apporder'];
        
        $where .= "and apporder = '$apporder'";

        $input_data['apporder'] = $apporder;
    
    }

    if($_GET['sdkorder']){
        
        $sdkorder = $_GET['sdkorder'];
        
        $where .= "and sdkorder = '$sdkorder'";

        $input_data['sdkorder'] = $sdkorder;
      
    }

}

$pay_info_log_sql = "select * from t_pay_info_log $where order by create_time desc limit ".$begin.','.LIST_PER_PAGE_RECORDS;
$pay_info_log = $db->fetchAll($pay_info_log_sql);

$count_sql = 'select count(*) as count from t_pay_info_log '.$where;

$counts      = $db->get_one_info($count_sql);
$pageHTML    = getPages($page, $counts['count'], LIST_PER_PAGE_RECORDS);

$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));

$endToday = $beginToday+86400-1;


$data_date = date('Y-m-d',$beginToday);

$smarty->assign("pageHTML", $pageHTML);
$smarty->assign("pay_info_log", $pay_info_log);
$smarty->assign("input_data", $input_data);
$smarty->assign("time_start", $_GET['dateStart']);
$smarty->assign("time_end", $_GET['dateEnd']);
$smarty->display("module/game_data/game_data.html");