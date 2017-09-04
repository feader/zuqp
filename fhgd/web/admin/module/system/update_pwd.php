<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include "../../../admin/class/admin_log_class.php";
include SYSDIR_ADMIN.'/include/global.php';
global $smarty, $centerdb, $auth,$dbConfig;

$dbname = $dbConfig['dbname'];
$session_data = get_session($dbname);
$admin_user_name = $session_data['admin_user_name'];

$dopost = $_POST['dopost'];
if(empty($dopost)) $dopost='';
if($dopost == 'update') {
    $username = $admin_user_name;
    $password = trim($_POST['password']);
    $pass_word = md5($password);
    $pwd = trim($_POST['pwd']);
    $pwd1 = trim($_POST['pwd1']);
    $query_st="select * from `t_admin_user` where `username`='$username'";
    $result=mysql_query($query_st);
    $rs = mysql_fetch_array($result);
    $passwd=$rs['passwd'];
    $uid=$rs['uid'];
    if($pass_word!=$passwd) {
        errorExit("原密码不正确,请重新输入！");
    }
    else {
        if(preg_match("#[^0-9a-zA-Z_]#", $pwd) ) {
            errorExit("密码或用户名不合法，<br />请使用[0-9a-zA-Z_]内的字符！");
        }
        if($pwd!=$pwd1) {
            errorExit("两次输入新密码不一致，请重新输入！");
        }
        else {
            $pwd= md5($pwd);
            $updateSql = 'UPDATE  `'.$centerdbConfig['dbname'].'`.`t_admin_user` SET passwd =  \'' .
                    $pwd .
                    '\' where uid='.$uid.'';
            $row2 = $centerdb->query($updateSql);
            $loger = new AdminLogClass();
            $loger->Log( AdminLogClass::TYPE_SYS_SET_PASSWORD,'', '','', $uid, $username);

            echo '<script language="javascript">window.alert("修改密码成功！");</script>';
            echo "<meta http-equiv=refresh content='1; url=update_pwd.php'>";
            exit();
        }
    }
}
$smarty->assign("pass_word",$pass_word);
$smarty->assign("username",$username);
$smarty->assign("passwd",$passwd);
$smarty->display('module/system/update_pwd.html');
//
////curl for post
//function make_request_post($url,$data,$timeout) {
////    $header = array(
////            'Accept-Language: zh-cn',
////            'Connection: Keep-Alive',
////            'Cache-Control: no-cache'
////    );
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    //指定post数据
//    curl_setopt($ch, CURLOPT_POST, 1);
//    //添加变量
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
////    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//    if ($timeout > 0) curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//    $result = curl_exec($ch);
//    curl_close($ch);
//    return $result;
//}