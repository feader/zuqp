<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

//统计每天玩家消耗钻石与每天充值的钻石
function auto_everyday($db){
    auto_everyday_total_dimond_log($db);
    auto_everyday_use_dimond_log($db);
}

function auto_everyday_total_dimond_log($db){
    
    $beginToday=mktime(0,0,0,date('m'),date('d')-1,date('Y'))+1;

    $endToday=mktime(0,0,0,date('m'),date('d'),date('Y'));

    $today = date('Y-m-d',$beginToday);

    $check_sql = "select * from t_everyday_total_dimond_log where date_time = '$today'";

    $check = $db->get_one_info($check_sql);

    if(!$check){
        
        $sql = "select sum(dimond_number) as total from t_recharge_log where create_time between $beginToday and $endToday and order_status = 1";

        $recharge_log_list = $db->get_one_info($sql);         

        $data = array();

        $data['date_time'] = $today;

        $data['today_total_dimond'] = $recharge_log_list['total'];

        $data['write_time'] = $beginToday;
        
        $res = $db->insert_data($data,'t_everyday_total_dimond_log');

        if($res){
             echo 'save data complete!';
        }else{
             echo 'save data fail!';
        }

    }else{
        
         echo 'already save data!';
    }
}

function auto_everyday_use_dimond_log($db){
    
    $beginToday=mktime(0,0,0,date('m'),date('d')-1,date('Y'))+1;

    $endToday=mktime(0,0,0,date('m'),date('d'),date('Y'));

    $today = date('Y-m-d',$beginToday);

    $check_sql = "select * from t_everyday_user_dimond_log where date_time = '$today'";

    $check = $db->get_one_info($check_sql);

    if(!$check){
        
        $sql = "select sum(use_dimond) as total from t_user_dimond_log where use_time between $beginToday and $endToday";

        $user_dimond_log_list = $db->get_one_info($sql);     

        $data = array();

        $data['date_time'] = $today;

        $data['everyday_total_use'] = $user_dimond_log_list['total'];

        $data['write_time'] = $beginToday;
        
        $res = $db->insert_data($data,'t_everyday_user_dimond_log');

        if($res){
             echo 'save data complete!';
        }else{
             echo 'save data fail!';
        }

    }else{
        
         echo 'already save data!';
    }
}

 


auto_everyday($db);










    



