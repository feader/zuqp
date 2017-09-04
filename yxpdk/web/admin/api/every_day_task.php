<?php
define('IN_DATANG_SYSTEM', true);
include "../../config/config.php";
include SYSDIR_ADMIN."/include/global2.php";
global $smarty,$db;

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
             echo 'auto_everyday_total_dimond_log save data complete!<br/>';
        }else{
             echo 'auto_everyday_total_dimond_log save data fail!<br/>';
        }

    }else{
        
         echo 'auto_everyday_total_dimond_log already save data!<br/>';
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
             echo 'auto_everyday_use_dimond_log save data complete!<br/>';
        }else{
             echo 'auto_everyday_use_dimond_log save data fail!<br/>';
        }

    }else{
        
         echo 'auto_everyday_use_dimond_log already save data!<br/>';
    }
}


// 【ACU】日平均在线人数 =早上8点到晚上24点每分钟同时在线总和 / (16小时*60)，
// 实时平均在线人数=0点到当前时间每分钟在线总和/(时间*60)
// 【DAU】日活跃用户数：当天登录游戏时间0.25小时以上的用户
// 【MAU】月活跃用户数：当月累计登录天数>=15天，且每次游戏时间>=0.25小时以上的用户
// 【用户活跃指数】：DAU/MAU
// 【PU】付费用户数：充值付费过的用户
// 【UV】当日登录账号数
// 【APA】活跃付费账号：活跃用户中的付费用户
// 【TS】用户平均在线时长：各用户在线时间总和 / UV当日登录帐号数
// 【用户流失率】游戏当前活跃用户数 / 历史注册总量
// 【活跃率】登陆人次 / 平均在线人数
// 【ARPU】用户每月平均消费
//     1、每月总收入 / 月付费用户数(月ARPU)
//     2、每日总收入 / 日付费用户数等(日ARPU)
// 【付费率】
//     1、注册用户付费率 = 总注册 / APA
//     2、平均在线付费率 = ACU / APA
//     3、活跃用户付费率 = UV / APA
// by 家富
// 按BI的统计，以次留为例，29号注册，30号有登陆的次留数据，应该是记在29的数据里
// 留存数据记录往前移动的一天（例：30->29），by孙总要求 2017.9.1


function retention($db,$n){
    
    $cibeginToday = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
    // $cibeginToday = mktime(0,0,0,8,25,2017);

    $ciendToday = $cibeginToday + 86400-1;

    $beginToday = $cibeginToday - 86400*($n-1);

    $endToday = $beginToday+86400-1;

    $cibeginToday_eight = $beginToday+28800;

    $ciendToday_eight = $beginToday+86400;

    $monthbegin = strtotime(date('Y')."-".date('m')."-1");

    $monthend = strtotime(date('Y')."-".date('m')."-".date('t'))+86400-1;

    //n留注册的用户
    $sql_ciliu_register = "select count(DISTINCT uid) as reg_num from t_game_user where register_time between $beginToday and $endToday";

    $ciliu_register_res = $db->get_one_info($sql_ciliu_register);

    $cost_dimond_sql = "SELECT sum(use_dimond) as use_dimond FROM `t_user_dimond_log` where use_time between $cibeginToday and $ciendToday";

    $user_cost_dimond = $db->get_one_info($cost_dimond_sql);

    $cost_money_sql = "SELECT sum(money_number) as charge_money FROM `t_recharge_log` where finish_time between $cibeginToday and $ciendToday and order_status = 1";

    $user_cost_money = $db->get_one_info($cost_money_sql);

    //n留有登陆的账号数
    $sql_ciliu_login = "select count(DISTINCT uid) as retention_num from t_game_user_login_log where last_login_time between $cibeginToday and $ciendToday and create_time between $beginToday and $endToday";

    $ciliu_login_res = $db->get_one_info($sql_ciliu_login);

    if(!$ciliu_login_res){
        
        $second_retention_login = 0;
    
    }else{
        
        $second_retention_login = $ciliu_login_res['retention_num'];
    
    }
    
    //n留
    @$retention = $second_retention_login/$ciliu_register_res['reg_num'];

    $retention = $retention ==false ? 0 : $retention;

    $date_time = date('Y-m-d',$beginToday);
    
    $date_time1 = date('Y-m-d',$beginToday-86400);

    $check_sql = "select id,data_time from t_data_count where data_time='$date_time'";

    $check = $db->get_one_info($check_sql);

    $data = array();

    $key_retention = get_switch_data($n);

    $acu_sql = "select sum(online) as online_num from t_online_log where dateline between $beginToday and $endToday";
    //日平均在线人数
    $acu = $db->get_one_info($acu_sql);

    $acu_res = number_format($acu['online_num']/(960),1,".","");

    $aacu_sql = "select sum(online) as online_num from t_online_log where dateline between $cibeginToday and $ciendToday_eight";

    $aacu = $db->get_one_info($aacu_sql);
    //实时平均在线人数
    $aacu_res = number_format($acu['online_num']/(1440),1,".","");

    $uv_sql = "select count(DISTINCT uid) as login_num from t_game_user_login_log where last_login_time between $beginToday and $endToday";
    //当日登陆账号数
    $uv = $db->get_one_info($uv_sql);

    $pu_sql = "select count(DISTINCT buyer_uid) as count_num from t_sell_log";
    //付费用户数
    $pu = $db->get_one_info($pu_sql);
    
    $all_register_sql = "select unionid from t_game_user where register_time < $beginToday";

    //历史注册总量
    $all_reg_info = $db->fetchAll($all_register_sql);

    $all_reg = 0;

    foreach ($all_reg_info as $k => $v) {
        
        if(strlen($v['unionid'])==28){
            
            $all_reg++;

        }

    }

    $dau_sql = "SELECT uid,sum(online_time) as total_online_time FROM t_game_user_login_log WHERE action = 'logout' and last_login_time between $beginToday and $endToday GROUP by uid";

    //日活跃用户数
    $dau_info = $db->fetchAll($dau_sql);

    $dau_res = 0;

    $in = 'in(';

    foreach ($dau_info as $k => $v) {
        
        if($v['total_online_time']>=900){
            
            $dau_res++;

        }

        $everyday_online_time_log_data = array();

        $everyday_online_time_log_data['uid'] = $v['uid'];

        $everyday_online_time_log_data['everyday_online_time'] = $v['total_online_time'];
        
        $everyday_online_time_log_data['create_time'] = time();
               
        $everyday_online_time_log_data['date_time'] = $date_time;

        $check_online_log = $db->get_one_info("select uid from t_everyday_online_time_log where uid = $v[uid] and date_time = '$date_time'");

        if(!$check_online_log){

            $insert_res = $db->insert_data($everyday_online_time_log_data,'t_everyday_online_time_log');

        }
               
        $in .= $v['uid'].',';         
        
    }
    
    $in = trim($in,',');

    $in .= ')';

    if(strlen($in)<=4){
        $dau_apa_sql = "select buyer_uid,count(DISTINCT buyer_uid) as num from t_sell_log where buyer_uid in('') group by buyer_uid";
    }else{
        $dau_apa_sql = "select buyer_uid,count(DISTINCT buyer_uid) as num from t_sell_log where buyer_uid $in group by buyer_uid";
    }  

    $dau_apa_info = $db->fetchAll($dau_apa_sql);

    $dau_apa = count($dau_apa_info);

    $mau1_sql = "SELECT *,count(*)as num FROM t_everyday_online_time_log WHERE create_time between $monthbegin and $monthend GROUP by uid having everyday_online_time >=900";

    //月活跃用户数
    $mau_info = $db->fetchAll($mau1_sql);

    $mau_res = 0;

    $in1 = 'in(';

    foreach ($mau_info as $k => $v) {
        
        if($v['num']>=15){
           
            $mau_res++;
        
        }

        $in1 .= $v['uid'].',';      
    }

    $in1 = trim($in1,',');

    $in1 .= ')';

    if(strlen($in1)<=4){
        $mau_apa_sql = "select buyer_uid,count(DISTINCT buyer_uid) as num from t_sell_log where buyer_uid in('') group by buyer_uid";
    }else{
        $mau_apa_sql = "select buyer_uid,count(DISTINCT buyer_uid) as num from t_sell_log where buyer_uid $in1 group by buyer_uid";
    }  

    $mau_apa_info = $db->fetchAll($mau_apa_sql);

    $mau_apa = count($mau_apa_info);

    $dts_sql = "SELECT sum(online_time) as total_online_time FROM t_game_user_login_log WHERE action = 'logout' and last_login_time between $beginToday and $endToday";

    $dts_info = $db->get_one_info($dts_sql);

    $dts = number_format($dts_info['total_online_time']/($uv['login_num']),1,".","");
    
    //日用户流失率
    $dul = $dau_res/$all_reg;

    //月用户流失率
    $mul = $mau_res/$all_reg;

    //活跃率
    $rhyl_sql = "SELECT count(DISTINCT uid) as count_uid FROM t_game_user_login_log WHERE action = 'login' and last_login_time between $beginToday and $endToday";

    $rhyl_info = $db->get_one_info($rhyl_sql);

    $rhyl = number_format($rhyl_info['count_uid']/$acu_res,1,".","");

    //月arpu
    $marpu_sql = "SELECT sum('money_number') as mmn FROM `t_recharge_log` where order_status = 1 and finish_time between $monthbegin and $monthend";

    $marpu_info = $db->get_one_info($marpu_sql);

    //月付费用户
    $mpu_sql = "SELECT count(*) as mmn FROM `t_sell_log` where action_time between $monthbegin and $monthend";

    $mpu_info = $db->get_one_info($mpu_sql);

    $marpu = $marpu_info['mmn']/1000;

    $marpu_res = number_format($marpu/$mpu_info['mmn'],1,".","");

    //日arpu
    $darpu_sql = "SELECT sum('money_number') as mmn FROM `t_recharge_log` where order_status = 1 and finish_time between $cibeginToday and $ciendToday";

    $darpu_info = $db->get_one_info($darpu_sql);

    //日付费用户
    $dpu_sql = "SELECT count(*) as mmn FROM `t_sell_log` where action_time between $cibeginToday and $ciendToday";

    $dpu_info = $db->get_one_info($dpu_sql);

    $darpu = $darpu_info['mmn']/1000;

    $darpu_res = number_format($darpu/$dpu_info['mmn'],1,".","");
    
    //付费率(日)
    $dau_reg_ffl = $all_reg/$dau_apa;

    $dau_avg_online_ffl = $acu_res/$dau_apa;

    $dau_nv_ffl = $uv['login_num']/$dau_apa;
    
    //付费率(实时)
    $mau_reg_ffl = $all_reg/$mau_apa;

    $mau_avg_online_ffl = $aacu_res/$mau_apa;

    $mau_nv_ffl = $uv['login_num']/$mau_apa;
    
    $au_res = $dau_res/$mau_res;

    $au_res = $au_res ? $au_res : 0;
    
    if($check){

        //$id = $check['id'];
        
        $data['action_time'] = time();

        //n留数据
        $data[$key_retention] = number_format($retention*100,2,".","");
       
        $res = $db->update_data($data,'t_data_count',"data_time = '$date_time'");

    }else{

        $data['register'] = $ciliu_register_res['reg_num'];
        
        $data['total_cost_dimond'] = $user_cost_dimond['use_dimond'] ? $user_cost_dimond['use_dimond'] : 0;

        $data['total_charge_money'] = $user_cost_money['charge_money'] ? $user_cost_money['charge_money'] : 0;

        $data['acu'] = $acu_res;
       
        $data['aacu'] = $aacu_res;
       
        $data['uv'] = $uv['login_num'];
       
        $data['pu'] = $pu['count_num'];
       
        $data['all_reg'] = $all_reg;
       
        $data['dau'] = $dau_res;
       
        $data['dau_apa'] = $dau_apa;
       
        $data['mau'] = $mau_res;
       
        $data['mau_apa'] = $mau_apa;
       
        $data['dts'] = $dts;
       
        $data['dul'] = $dul;
       
        $data['mul'] = $mul;
       
        $data['rhyl'] = $rhyl;
       
        $data['marpu'] = $marpu_res;
       
        $data['darpu'] = $darpu_res;
       
        $data['dau_reg_ffl'] = $dau_reg_ffl;   
       
        $data['dau_avg_online_ffl'] = $dau_avg_online_ffl;   
       
        $data['dau_nv_ffl'] = $dau_nv_ffl;
       
        $data['mau_reg_ffl'] = $mau_reg_ffl;  
       
        $data['mau_avg_online_ffl'] = $mau_avg_online_ffl;  
       
        $data['mau_nv_ffl'] = $mau_nv_ffl;   
       
        $data['au'] = $au_res;

        $data['data_time'] = $date_time;

        $data['action_time'] = time();
    
        $data['create_time'] = time();
        
        $data['register'] = $ciliu_register_res['reg_num'];
        
        $data['total_cost_dimond'] = $user_cost_dimond['use_dimond'] ? $user_cost_dimond['use_dimond'] : 0;

        $data['total_charge_money'] = $user_cost_money['charge_money'] ? $user_cost_money['charge_money'] : 0;

        $res = $db->insert_data($data,'t_data_count');

    }

    echo $key_retention.' count complete!<br/>';
    
    return $res;

}

function get_switch_data($n){
    switch ($n) {
        case 2:
            $n_rentention = 'second_retention';
            break;
        case 3:
            $n_rentention = 'third_retention';
            break;
        case 4:
            $n_rentention = 'fourth_retention';
            break;
        case 5:
            $n_rentention = 'fifth_retention';
            break;      
        case 6:
            $n_rentention = 'sixth_retention';
            break;
        case 7:
            $n_rentention = 'seventh_retention';
            break;
        case 14:
            $n_rentention = 'fourteenth_retention';
            break;
        case 30:
            $n_rentention = 'thirty_retention';
            break;                      
    }
    return $n_rentention;
} 

function getthemonth($date){
    $firstday = strtotime(date('Y-m-01', strtotime($date)));
    $lastday = strtotime(date('Y-m-d', strtotime("$firstday+1 month-1")));
    return array($firstday,$lastday);
}


auto_everyday($db);

retention($db,2);
retention($db,3);
retention($db,4);
retention($db,5);
retention($db,6);
retention($db,7);
retention($db,14);
retention($db,30);