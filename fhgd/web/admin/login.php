<?php
define('IN_DATANG_SYSTEM', true);
include "../config/config.php";
include "../admin/class/admin_log_class.php";
include SYSDIR_ADMIN . "/include/global.php";
global $smarty, $auth,$dbConfig;

$dbname = $dbConfig['dbname'];

$smarty->assign('agent_id', $AGENT_ID);
if (isset($_COOKIE['dt'])) {
    $smarty->assign('username', encrypt($_COOKIE['dt'],'D',$dbname));
    $smarty->assign('password', encrypt($_COOKIE['ok'],'D',$dbname));
    $smarty->assign('checked', $_COOKIE['checked']);
}

@$action = trim($_REQUEST['action']);
if ($action == 'login') {
    //  if ($auth->alreadyLogin()) {
    //      header("Location:/web/admin/index.php");
    //      exit();
    //  }
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);
    $validation = trim($_POST['validation']);
    $setcookie = 1;

    if ($validation != $_SESSION['code']) {
        $smarty->assign('errorMsg', '验证码错误');
        $smarty->display('login.html');
        exit();
    }
    
    if (($result = validUsername($username)) !== true) {
        $smarty->assign('errorMsg', $result);
        $smarty->display("login.html");
        exit();
    }

    if (($result = validPassword($password)) !== true) {
        $smarty->assign('errorMsg', $result);
        $smarty->display("login.html");
        exit();
    }
    
    if ($auth->login($username, $password, $AGENT_ID)) {
        // $loger = new AdminLogClass();
        // $loger->Log( AdminLogClass::TYPE_SYS_LOGIN,'', '','', '', '');
        //登录成功，跳转到首页
        $setcookie == 1 ? savePasswd($setcookie, $username, $password,$dbname) : savePasswd(0);
        unset($_SESSION['code']);
        //header("Location:/web/admin/index.php");
        header("Location:index.php");
        exit();
    }
    else {
        unset($_SESSION['code']);
        $errorMsg = "用户名或者密码错误，请重新输入";
        $smarty->assign('errorMsg', $errorMsg);
        $smarty->display("login.html");
        exit();
    }
}

else {
    $smarty->display("login.html");
    exit();
}

function savePasswd($flag, $username, $password,$dbname)
{   
    if ($flag == 1) {
        setcookie(dt, encrypt($username,'E',$dbname), time() + 60 * 60 * 24 * 7);
        setcookie(ok, encrypt($password,'E',$dbname), time() + 60 * 60 * 24 * 7);
        setcookie(checked, 1, time() + 60 * 60 * 24 * 7);
    } else {
        setcookie(dt, $username, time() - 1);
        setcookie(ok, $password, time() - 1);
        setcookie(checked, 0, time() - 1);
    }
}

/*
* @ $string 需要加密解密的字符串
* @ $operation：判断是加密还是解密，E表示加密，D表示解密； 需要加密解密的字符串
* @ $key：密匙
*/ 
function encrypt($string,$operation,$key=''){ 
    $key=md5($key); 
    $key_length=strlen($key); 
    $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string; 
    $string_length=strlen($string); 
    $rndkey=$box=array(); 
    $result=''; 
    for($i=0;$i<=255;$i++){ 
           $rndkey[$i]=ord($key[$i%$key_length]); 
        $box[$i]=$i; 
    } 
    for($j=$i=0;$i<256;$i++){ 
        $j=($j+$box[$i]+$rndkey[$i])%256; 
        $tmp=$box[$i]; 
        $box[$i]=$box[$j]; 
        $box[$j]=$tmp; 
    } 
    for($a=$j=$i=0;$i<$string_length;$i++){ 
        $a=($a+1)%256; 
        $j=($j+$box[$a])%256; 
        $tmp=$box[$a]; 
        $box[$a]=$box[$j]; 
        $box[$j]=$tmp; 
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256])); 
    } 
    if($operation=='D'){ 
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
            return substr($result,8); 
        }else{ 
            return''; 
        } 
    }else{ 
        return str_replace('=','',base64_encode($result)); 
    } 
}