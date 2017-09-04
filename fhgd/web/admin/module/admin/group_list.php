<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include "../../../admin/class/admin_log_class.php";
include SYSDIR_ADMIN.'/include/global.php';
global $smarty, $db;


if($_GET['action'] == 'delete'){
    $gid = $_GET['gid'];
    $gname = $_GET['name'];
    $sql_check = 'select * from '.T_ADMIN_USER.' where gid='.$gid;
    $result_check = $db->get_one_info($sql_check);
    
    if(empty($result_check)){
        $sql_delete = 'delete from t_group where gid='.$gid;

        $db->get_one_info($sql_delete);
       
        // $loger = new AdminLogClass();
        // $loger->Log( AdminLogClass::TYPE_SYS_DELETE_ADMIN_GROUP,'', '','', '', $gname);      
        $db->jump('处理完成！');
        
    }else{
              
        $db->jump('群组还有群组成员，删除群组失败！');
    }
    
    exit();
}

// $sql_group = 'select gid,name from t_group order by gid asc';
// $result_group = $centerdb->fetchAll($sql_group);
// $sql_admin = 'select uid,username,gid from  '.T_ADMIN_USER;
// $result_admin = $centerdb->fetchAll($sql_admin);
// $result = array();
// foreach($result_admin as $v){
//     $admin[$v['uid']] = $v['username'];
// }
// foreach($result_group as $value)
// {
//     $result[$value['gid']] = $value;
// }
// foreach($result_admin as $value)
// {
//     $result[$value['gid']]['admin'][] = $value['uid'];
// }
// foreach($result as $value)
// {
//     $data[] = $value;
// }

// unset($result_group,$result_admin,$result);

// $smarty->assign('admin',$admin);
// $smarty->assign('data',$data);
// $smarty->display('module/backstat/group_list.html');






