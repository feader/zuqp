<?php
if (!defined('MING2_WEB_ADMIN_FLAG')) {
	exit ('hack attemp');
}

if (!defined("LIST_PER_PAGE_RECORDS"))
	define("LIST_PER_PAGE_RECORDS", 10);
if (!defined("LIST_SHOW_PREV_NEXT_PAGES"))
	define("LIST_SHOW_PREV_NEXT_PAGES", 7); //First Prev 1 2 3 4 5 6 7 8 9 10... Next Last

include SYSDIR_ADMIN."/class/sql_select_class.php";
include SYSDIR_ADMIN."/class/sql_func_helper_class.php";


/**
 * 根据记录总数和每页记录数获得分页数
 *
 * @param int $counts
 * @param int $rsPerPage
 * @return int
 */
function getNumsOfPage($counts, $rsPerPage, $max = 0)
{
    $tmp = (($counts % $rsPerPage) == 0) ? ($counts / $rsPerPage) : (floor($counts / $rsPerPage) + 1);   
    if ($max > 0)
    {
        if ($tmp > $max)
        {
            $tmp = $max; 
        }
    }
    return intval($tmp);
}

/**
 * 验证用户名是否合法
 * @param $username
 * 
 * @return true | $errorMsg
 */
function validUsername($username) {
	$username = trim($username);
	if ($username == '') {
		return '用户名不能为空';
	}
	if (preg_match("/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_]+$/u", $username) == 0) {
		return '用户名只能由英文、数字、中文以及下划线组成';
	}
	return true;
}

function validChinese($str) {
	$str = trim($str);
	if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $str) == 0) {
		return false;
	}
	return true;
}

/**
 * 验证密码是否合法
 * @param $password
 * 
 * @return true | $errorMsg
 */
function validPassword($password) {
	$username = trim($password);
	if ($username == '') {
		return '密码不能为空';
	}
	if (preg_match("/^[0-9a-zA-Z_]+$/u", $password) == 0) {
		return '密码只能由英文、数字以及下划线组成';
	}
	return true;
}

/**
 * 访问Service，但不关注返回值
 * @param $url
 */
function getNothing($url) {
	@ file_get_contents($url);
}

/**
 * 通过返回指定URL的erlang web服务获取JSON
 * @param $url
 */
function getJson($url) {
	global $smarty;
	$result = @ file_get_contents($url);
	if ($result) {
		return json_decode($result, true);
	}
	$smarty->assign(array (
		'errorMsg' => 'erlang web尚未启动或者访问出错:' . $url
	));
	$smarty->display("error.html");
	exit ();
}

function getWebJson($urlPath)
{
	global $erlangWebAdminHost;
	$result = @ file_get_contents($erlangWebAdminHost.$urlPath);
	if ($result) {
		return json_decode($result, true);
	}
}

function errorExit($msg) {
	global $smarty;
	$smarty->assign(array (
		'errorMsg' => $msg
	));
	$smarty->display("error.html");
	exit ();
}

function succExit($msg, $url = '') {
	if (!$url) {
		$url = $_SERVER['HTTP_REFERER'];
	}
	global $smarty;
	$smarty->assign(array (
		'info' => $msg,
		'url' => $url
	));
	$smarty->display("succ.html");
	exit ();
}

function infoExit($msg, $url = '') {
	if (!$url) {
		$url = $_SERVER['HTTP_REFERER'];
	}
	global $smarty;
	$smarty->assign(array (
		'info' => $msg,
		'url' => $url
	));
	$smarty->display("succ.html");
	exit ();
}


/**
 * SQL的参数值的安全过滤
 * 所有SQL语句的参数，都必须用这个函数处理一下。目的：防SQL注入攻击!!
 * @param $name
 */
function SS($name) {
	$name = trim($name);
	if (get_magic_quotes_gpc()) {
		//$name = stripslashes($name);
		return $name;
	} else {
		return mysql_real_escape_string($name);
	}
}

/**
 * 获取URL参数值
 * @param $name
 */
function getUrlParam($name = 'pid') {
	$v = intval($_REQUEST[$name]);
	$v = ($v < 1) ? 1 : $v;
	return $v;
}


///日期的常用操作方法
/**
 * 返回当前天0时0分0秒的时间
 * @param $outstring	是否返回字符串类型，默认为false
 * 			如果$outstring为true则返回该时间的字符串形式，否则为时间戳
 */
function GetTime_Today0($outstring = false){
	$str_today0 = strftime ("%Y-%m-%d", time());
	$result = strtotime ($str_today0);
	if ($outstring)
		return strftime ("%Y-%m-%d %H:%M:%S", $result );
	else
		return $result;
}
	
////////////////////////////////////////////////////////////
///数据库的常用操作方法

/**
 * 执行SQL查询，获取结果集的第一行
 * @param $sql
 */
function GFetchRowOne ($sql){
	global $db;
	return $db->fetchOne($sql);
}

/**
 * 执行SQL查询，获取结果集的全部
 * @param $sql
 */
function GFetchRowSet($sql){
	global $db;
	return $db->fetchAll($sql);
}

/**
 * 生成这样子的SQL字符串
 * `aaa` = '1' OR `aaa` = '2' OR ....
 */
function makeOrSqlFromArray($filed, $arr){
	$str = '';
	if (is_array($arr))
		foreach($arr as $k=>$v)
		{
		if (empty($str))
			$str = "( `{$filed}`='{$k}'";
		else
			$str .= " OR `{$filed}`='{$k}'";
		}
	return $str . ') ';
}

////////////////////////////////////////////////////////////
///分页显示的常用操作方法
/**
 * 查询结果的分页列表
 * 参数： 当前第几页， 总共多少条记录， 每页显示多少条记录
 */
function getPages($pageno, $record_count, $per_page_record = LIST_PER_PAGE_RECORDS) {
	$record_count = intval($record_count);
	$total_page = ceil($record_count / $per_page_record);
	if ($total_page < 2)
		return null;

	$start = ($pageno > LIST_SHOW_PREV_NEXT_PAGES) ? ($pageno -LIST_SHOW_PREV_NEXT_PAGES) : 1;
	$end = $start +LIST_SHOW_PREV_NEXT_PAGES * 2;
	if ($end > $total_page)
		$end = $total_page;
	global $buf_lang;
	//$arr['首页'] = 1;
	$arr[$buf_lang['conmon']['home_page']] = 1;
	//$arr['上页'] = ($pageno > 1) ? ($pageno -1) : 1;
	$arr[$buf_lang['conmon']['previous_page']] = ($pageno > 1) ? ($pageno -1) : 1;
	for ($i = $start; $i <= $end; $i++) {
		if ($i == $pageno)
			$arr["<font color=red>{$i}</font>"] = $i;
		else
			$arr[$i] = $i;
	}
	//$arr['下页'] = ($pageno < $total_page) ? ($pageno +1) : $total_page;
	$arr[$buf_lang['conmon']['next_page']] = ($pageno < $total_page) ? ($pageno +1) : $total_page;
	//$arr['末页'] = $total_page;
	$arr[$buf_lang['conmon']['last_page']] = $total_page;

	return $arr;
}

/**
 * 查询数据库记录总数
 */
function getRecordCount($tablename, $where = '') {
	global $db;
	$sql = "SELECT COUNT(*) as c FROM `{$tablename}` ";
	
	if (!empty ($where))
		$sql .= " WHERE  " . $where;
	
	$row= $db->fetchOne($sql);
	return $row['c'];
}

/**
 * 分页取数据
 * 参数是:  表名， 条件， 页数(从1开始)， 排序字段(可多个字段)，每页多少个记录
 */
function getList($tablename, $where, $pageno = 1, $order = "id", $per_page_record = LIST_PER_PAGE_RECORDS, & $counts) {
	global $db;
	$sql = SqlSelectClass :: getInstance($tablename, true, true)->select('*')->where($where)->orderby($order)->limit(SqlFuncHelperClass :: calcLimitOffset($pageno, $per_page_record), $per_page_record)->createSql();
	$rowset = $db->fetchAll($sql);
	
	$counts = GFetchRowOne('SELECT FOUND_ROWS() as counts;');
	$counts = $counts['counts'];
			
	return $rowset;
}

function GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])) $cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"])) $cip = $_SERVER["REMOTE_ADDR"];
	else $cip = "";
	return $cip;
}

//CRUL BY POST METHOD
function PostCurl($url,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //指定post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    //添加变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function parse_agent_name($name_arr)
{
	$new_agent_name = array();
	foreach($name_arr as $a_id => $a_name)
	{	
		if (preg_match("/\(关\)/i", $a_name) || preg_match("/agent/i", $a_name)) {
			$new_agent_name[$a_id] = $a_name;
		}else{
			$new_agent_name[$a_id] = "<b><font color='green'>{$a_name}</font></b>";
		}
	}
	return $new_agent_name;
}

function mem(){
	$mem = new Memcache;
	$mem->connect('localhost',11210);
}

/*
* 设置session
* @param String $name  session name
* @param Mixed $data  session data
* @param Int  $expire 超时时间(秒)
*/
function set_session($name, $data, $expire=600){
	$session_data = array();
	$session_data['data'] = $data;
	$session_data['expire'] = time()+$expire;
	$_SESSION[$name] = $session_data;
}
 
/*
* 读取session
* @param String $name session name
*	@return Mixed
*/ 
function get_session($name){
	if(isset($_SESSION[$name])){
	    if($_SESSION[$name]['expire']>time()){
	    	return $_SESSION[$name]['data'];
	  	}else{
	    	clear_session($name);
	  	}
	}
	return false;
}
 
/*
* 清除session
* @param String $name session name
*/
function clear_session($name){
	unset($_SESSION[$name]);
}