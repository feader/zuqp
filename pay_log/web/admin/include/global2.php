<?php

include SYSDIR_ADMIN."/class/auth.class.php";
include SYSDIR_ADMIN."/class/db.class.php";
include SYSDIR_ADMIN."/class/tool.class.php";
include SYSDIR_ADMIN."/class/user.class.php";

include SYSDIR_ADMIN."/library/smarty/Smarty.class.php";
include SYSDIR_ADMIN."/include/functions.php";
include SYSDIR_ADMIN."/include/db_defines.php";
include SYSDIR_ADMIN."/include/lang/zh-tw.php";
include SYSDIR_ADMIN."/include/lang/zh-cn.php";
include SYSDIR_ADMIN."/include/lang/en.php";
include SYSDIR_ADMIN."/include/lang/vn.php";
include SYSDIR_ADMIN."/include/lang/kor.php";

global $smarty, $auth, $db, $dbConfig, $AGENT_ID ,$tool;

ob_start();
session_start();

//初始化smarty
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->force_compile = true;
$smarty->template_dir = SYSDIR_ADMIN."/template/default/";
$smarty->compile_dir = SYSDIR_ADMIN."/template_c";
$smarty->left_delimiter = '<{';
$smarty->right_delimiter = '}>';

//初始化数据库连接
$db = new DBClass();
$db->connect($dbConfig);

$auth = new AuthClass();
// if (!isset($_SESSION['agency_user_name'])){
// 	if (!$auth->auth()) {
// 		header("Location:/houtai/scmj/web/admin/module/agency/agency_login.php");
// 		exit();
// 	} 
// 	//更新最后操作时间
// 	//$_SESSION['last_op_time'] = time();
// }

$tool = new ToolClass();

//获取开服日期
define("SERVER_ONLINE_DATE", getServerOnlineDate());

/**
 * 获取开服日期（字符串）
 * TODO:需要读取公共配置common.config文件，临时返回一个日期
 */
function getServerOnlineDate(){
	return "2011-06-05";
}

//定义语言包 12-1-12                 start

$lang_type = isset($_REQUEST['LANG']) ? $_REQUEST['LANG'] : '';
if($lang_type != ''){
	$_SESSION['langsession'] = $lang_type;
}

$buf_lang = array();  
if(isset($_SESSION['langsession']) && $_SESSION['langsession'] != ''){
	switch ($_SESSION['langsession'])
	{
	case 'ZH_CN':
	  $buf_lang = $ZH_CN;
	  break;  
	case 'ZH_TW':
	  $buf_lang = $ZH_TW;
	  break; 
	case 'EN':
	   $buf_lang = $EN;
	  break;
	case 'VN':
	   $buf_lang = $VN;
	  break;
	case 'KOR':
	   $buf_lang = $KOR;
	  break;
	default:
	   $buf_lang = $ZH_CN;
	  break;
	}	
}
else
{
	if($AGENT_ID == 2) //台服繁体
	{
		$buf_lang = $ZH_TW;
	}
	else if($AGENT_ID == 15) //越南语
	{
		$buf_lang = $VN;
	}
	else if($AGENT_ID == 49) //韩语
	{
		$buf_lang = $KOR;
	}
	else
	{
		$buf_lang = $ZH_CN;
	}
}

$select_lang=$_SESSION['langsession'];
if(empty($select_lang))
{
	if($AGENT_ID == 2) //台服繁体
	{
		$select_lang = 'ZH_TW';
	}
	else if($AGENT_ID == 15) //越南语
	{
		$select_lang = 'VN';
	}
	else if($AGENT_ID == 49) //韩语
	{
		$select_lang = 'KOR';
	}
	else
	{
		$select_lang = 'ZH_CN';
	}
} 

$smarty->assign("_lang", $buf_lang);
$smarty->assign("lang_type", $select_lang);  
//                       语言包       end


//页面显示的定义
header('Content-Type: text/html; charset=UTF-8');
define(LIST_PER_PAGE_RECORDS, 2); //Search page show ... records per page
define(LIST_SHOW_PREV_NEXT_PAGES, 7); //First Prev 1 2 3 4 5 6 7 8 9 10... Next Last


