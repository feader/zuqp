<?php
class DBClass
{
	/**
	 * 
	 * 数据库连接
	 * @var resource 
	 */
	private $conn = null;
	
	private $query_result;
	
	private $rows;
	
	/**
	 * 
	 * 连接数据库
	 * @param array $config
	 * @throws Exception
	 */
	public function connect($config)
	{
		if (!is_resource($this->conn)) {
			$user = $config['user'];
			$passwd = $config['passwd'];
			$host = $config['host'];
			$dbname = $config['dbname'];
			$link = @mysql_connect($host, $user, $passwd);
			if (!$link){
				throw new Exception("数据连接失败:" . mysql_error());
			}
			$this->conn = $link;
			if (!mysql_select_db($dbname, $link)) {
				throw new Exception("选择数据库表错误:" . mysql_error());		
			}
			mysql_query("set names utf8", $link);
		}
	}
	
	public function begin()
	{
		
	}
	
	public function rollback()
	{
		
	}
	
	public function commit()
	{
		
	}
	
	/**
	 * 执行sql语句，并返回Resource
	 * @param string $sql
	 * @throws Exception
	 * @return resource
	 */
	public function query($sql)
	{
		$sql = trim($sql);
		if ($sql == '') {
			throw new Exception("SQL语句不能为空");
		}
		if (!$this->conn) {
			global $dbConfig;
			$this->connect($dbConfig);
		}
		$result = mysql_query($sql, $this->conn);
		if ($result === false) {
			throw new Exception("sql执行出错:" . $sql . "   " . mysql_error());
		}
		$this->query_result=$result;
		return $result;
	}
	
	/**
	 * 执行select语句并返回结果
	 * @param string $sql
	 * @return array
	 */
	public function fetchAll($sql) 
		{
		$this->query($sql);
		return $this->getAll($this->query_result);
		}
	
	public function fetchOne($sql)
	{
		$this->query($sql);
		return $this->getOne($this->query_result);
	}
	
	public function getOne($result) 
	{
		if ($this->query_result) {
			$result =  mysql_fetch_assoc($this->query_result);
			if (!$result) {
				return array();
			}
			return $result;
		}
		throw new Exception("获取sql执行结果出错，可能尚未执行sql");
	}
	
	public function getAll($result) 
	{
		if ($this->query_result) {
			$this->rows = array();
			while (($row = mysql_fetch_assoc($this->query_result)) !== false) {
				array_push($this->rows, $row);
			}
			return $this->rows;
		}
		throw new Exception("获取sql执行结果出错，可能尚未执行sql");
	}

	public function update_agent($sql){		
		$updata_res=mysql_query($sql);
		$res=mysql_affected_rows();
		return $res;
		
	}

	/**
	 *  查询一条记录
	 *  @param string $sql 查询语句
	 *  @return array  二维数组
	 *  @author teacher lin
	 *  @email lin_wengdo@qq.com 
	 */
	function get_one_info($sql){

	    $res = mysql_query($sql);
	    if($res){
	        $data_info = mysql_fetch_assoc($res);
	    }else{
	        //exit('查询不到记录，错误为：'.mysql_error());
	        $this->jump('非法操作！');
	    }

	    return $data_info;
	}
	
	/**
	 *  修改记录函数
	 *  @param array $data 关联数组(一维)
	 *  @param string $table 数据表
	 *  @param string $where 条件（格式：`字段`=值）
	 *  @return int 影响行数
	 *  @author teacher lin
	 *  @email lin_wengdo@qq.com 
	 */
	function update_data($data,$table,$where)
	{
		$str = '';
	    foreach ($data as $key => $value) {
	    	$v1 = $this->check_input($value);
	        $str .= "`$key`=$v1,";
	    }
	    $str = rtrim($str,',');
	    
	    $update_sql = "update $table set $str where $where";

	    mysql_query($update_sql);
	    return mysql_affected_rows(); //影响行数
	}

	/**
	 *  添加记录函数
	 *  @param array $data 关联数组(一维)
	 *  @param string $table 数据表
	 *  @return int 插入的主键id
	 *  @author teacher lin
	 *  @email lin_wengdo@qq.com 
	 */
	function insert_data($data,$table)
	{
		$k = '';
	    $v = '';
	    $data1 = array();
	    
	    foreach ($data as $key => $value) {
	        $k .= '`'.$key.'`,';
	        //$v .= "'$value',";
	        $v1 = $this->check_input($value);
	        $v .= "$v1,";
	    }
	    $k = rtrim($k,',');
	    $v = rtrim($v,',');  

	    $insert_sql = "insert into $table($k) values($v)";	    
	    mysql_query($insert_sql);
	    return mysql_insert_id(); //插入的主键id
	} 

	/**
	 *  删除记录函数
	 *  @param string $table 数据表
	 *  @param string $where 条件（格式：`字段`=值）
	 *  @return int 影响行数
	 *  @author teacher lin
	 *  @email lin_wengdo@qq.com 
	 */
	function delete_data($table,$where)
	{
		$sql = "delete from $table where $where";		
		mysql_query($sql);
		return mysql_affected_rows();
	}

	/**
	 * 跳转函数
	 * @param string $msg 提示信息
	 * @param string $url 跳转地址
	 * @return string 
	 * @author teacher lin
	 * @email lin_wengdo@qq.com 
	 */
	function jump($msg,$url='')
	{
		$str = '<script type="text/javascript">';
		$str .= 'alert("'.$msg.'");';
		
		if($url!=''){
			$str .= 'location.href="'.$url.'";';
		}else{
			$str .= 'history.go(-1);';
		}
		
		$str .= '</script>';

		exit($str);
	}

	
	function check_input($value){		
	$value = trim($value);	
	// 去除斜杠
	if (get_magic_quotes_gpc()){
	  $value = stripslashes($value);
	}
	// 如果不是数字则加引号
	if (!is_numeric($value)){

	  	$value = "'" . mysql_real_escape_string($value) . "'";
	}
	return $value;
	}

	function write_with_open($filename,$str){
	
		$fp = fopen('../logs/'.$filename, 'a') or die("can't open $filename for write");

		$str .= "\r\n";
		
		fwrite($fp, $str);

		fclose($fp);
	}
}