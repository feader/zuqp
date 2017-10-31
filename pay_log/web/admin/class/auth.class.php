<?php
global $db;

if (!defined('MING2_WEB_ADMIN_FLAG')) {
	exit('hack attemp');
}
class AuthClass
{
	/**
	 * 验证是否有权限
	 *
	 * @return bool
	 */
	public function auth()
	{
		if ($this->alreadyLogin() || $this->_checkTicket() || $this->agencyalreadyLogin()) {
			return true;
		}
		return false;
	}

	public function alreadyLogin()
	{
		global $dbConfig;
		$dbname = $dbConfig['dbname'];		
		$session_data = $this->get_session($dbname);
		$username = $session_data['admin_user_name'];
		$lastOPTime = $session_data['last_op_time'];
		$uid = $session_data['uid'];
		if ($uid > 0 && $username != '' && (time() - $lastOPTime > -1)) {
			return true;
		}
		return false;
	}

	public function agencyalreadyLogin(){
	    global $dbConfig;
		$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];	
		$session_data = $this->get_session($dbname);
		$agency_user_name = $session_data['agency_user_name'];
		$lastOPTime = $session_data['last_login_time'];
		$auid = $session_data['auid'];
	
	    if (!empty($auid) && isset($auid) && !empty($agency_user_name) && isset($agency_user_name) && (time() - $lastOPTime > -1)) {

	        return true;

	    }

	    return false;

	}

	
	public function userid(){
		return $_SESSION['uid'] ;
	}

	public function username(){
		return $_SESSION['admin_user_name'] ;
	}

	/**
	 *
	 * 用户登录认证
	 * @param string $username
	 * @param string $password
	 * @return integer | false
	 */
	public function login($username, $password, $agent_id)
	{
		global $db,$dbConfig;
		//用户名和密码都是已经经过过滤的了
		$username = addslashes($username);
		$password = strtolower(md5($password));
		$login_time = time();
		$sql = "SELECT uid, agent_id ,gid FROM ".T_ADMIN_USER
				." where username='$username' and passwd='$password'";
		$result = $db->fetchOne($sql);
        $agent_id_list = $result['agent_id'];
		$agent_id_array = explode(' ', $agent_id_list);
		// $key = array_search($agent_id, $agent_id_array);
		$key = TRUE;
		
		$data = array();
		$data['last_login_time'] = $login_time;
		$uid = $result['uid'];
		$res = $db->update_data($data,'t_admin_user',"uid=$uid");
		
		if (!empty($result) && $key !== FALSE) {
			$dbname = $dbConfig['dbname'];
			$session_data = array();
			$session_data['admin_user_name'] = $username;
			$session_data['uid'] = $result['uid'];
			$session_data['gid'] = $result['gid'];
			$session_data['last_op_time'] = time();
			
			$this->set_session($dbname, $session_data, 7200);
			return true;
		}
		return false;
	}

	public function agencyLogin($username, $password) {
		global $db,$dbConfig;
		//用户名和密码都是已经经过过滤的了
		$username = addslashes($username);
		$password = addslashes($password);
		$sql = "SELECT uid,first_login_time,grade FROM t_agency where uid='$username' and password='$password'";
		$result = $db->fetchOne($sql);

		$data = array();
		$data['last_login_time'] = time();
		$uid = $result['uid'];

		$res = $db->update_data($data,'t_agency',"uid='$uid'");

		// print_r($result);die();

		if (!empty($result)) {
			$dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
			$session_data = array();
			$session_data['agency_user_name'] = $result['uid'];
			$session_data['auid'] = $result['uid'];
			$session_data['grade'] = $result['grade'];
			$session_data['last_login_time'] = time();
			$session_data['first_login_time'] = $result['first_login_time'];
			$this->set_session($dbname, $session_data, 7200);
			return true;
		}
		return false;
	}

	
	public function changeServer($username, $password, $agent_id)
	{
		global $db;
		//用户名和密码都是已经经过过滤的了
		$username = addslashes($username);
		$password = strtolower($password);
		$sql = "SELECT uid, agent_id FROM ".T_ADMIN_USER
				." where username='$username' and passwd='$password'";
		$result = $db->fetchOne($sql);

		$agent_id_list = $result['agent_id'];
		$agent_id_array = explode(' ', $agent_id_list);
		$key = array_search($agent_id, $agent_id_array);
				
		if (!empty($result) && $key !== FALSE) {
			$_SESSION['admin_user_name'] = $username;
			$_SESSION['uid'] = $result['uid'];
			$_SESSION['last_op_time'] = time();
			return true;
		}
		return false;
	}


	/**
	 * ticket验证方式
	 *
	 * @return bool
	 */
	private function _checkTicket()
	{
		// username uid filename ticket time
		return false;
	}

	//获取用户权限
	public function getUserPower($arr = array())
	{
		global $db ,$dbConfig;
		$dbname = $dbConfig['dbname'];
		$session_data = $this->get_session($dbname);
		//$username = $_SESSION['admin_user_name'];
		$username = $session_data['admin_user_name'];
		$sql = "SELECT g.power FROM ".T_ADMIN_USER." a,t_group g where a.gid=g.gid and username='$username'";
		$result = $db->fetchOne($sql);
		$group_power = $result['power'];
		return AuthClass::getAuthority($group_power,$arr);
	}

        public function getUserPower2($arr = array())
        {
        global $db ,$dbConfig;
        $dbname = $dbConfig['dbname'].'_'.$dbConfig['user'];
		$session_data = $this->get_session($dbname);
		// $username = $_SESSION['admin_user_name'];
		$username = $session_data['admin_user_name'];
		$sql = "SELECT g.power FROM ".T_ADMIN_USER." a,t_group g where a.gid=g.gid and username='$username'";
		$result = $db->fetchOne($sql);
		$group_power = $result['power'];
		return AuthClass::getAuthority($group_power,$arr);
        }

	//转换用户权限
	public function getAuthority($user_power , $arr = array())
	{
		$authArray = explode(' ', $user_power);

		$authList = AuthClass::getAuthorityList($arr);

		foreach($authArray as $key => $value)
		{
			$authArray[$key] = $authList[$value];
		}
		return $authArray;
	}

	public function getAuthorityList($arr = array())
	{
		return array(
			//数据总览(1~19)		
			'1' => array("man_id" => '1', "desc" => "数据总览", "url" =>'module/game_data/game_data.php', "man_type"=>'GAME_DATA'),
			'2' => array("man_id" => '2', "desc" => "订单查询", "url" =>'module/game_data/data_count.php', "man_type"=>'GAME_DATA'),
			//'3' => array("man_id" => '3', "desc" => "房间记录", "url" =>'module/game_data/room_log.php', "man_type"=>'GAME_DATA'),

			//游戏管理(20~39)		
			// '20' => array("man_id" => '20', "desc" => "消耗钻石", "url" =>'module/game_manager/dimond_log_list.php', "man_type"=>'GAME_MANAGER'),
			// '21' => array("man_id" => '21', "desc" => "玩家反馈", "url" =>'module/game_manager/user_complain.php', "man_type"=>'GAME_MANAGER'),
			// '22' => array("man_id" => '22', "desc" => "钻石明细", "url" =>'module/game_manager/dimond_used_list.php', "man_type"=>'GAME_MANAGER'),
			// '23' => array("man_id" => '23', "desc" => "日志管理", "url" =>'module/game_manager/admin_action_log.php', "man_type"=>'GAME_MANAGER'),
			// '24' => array("man_id" => '24', "desc" => "线下赛", "url" =>'module/game_manager/offline_player_list.php', "man_type"=>'GAME_MANAGER'),
			// '25' => array("man_id" => '25', "desc" => "游戏公告", "url" =>'module/game_manager/game_notice.php', "man_type"=>'GAME_MANAGER'),

			//用户管理(40~59)		
			// '40' => array("man_id" => '40', "desc" => "用户查询", "url" =>'module/user_manager/query_user_info.php', "man_type"=>'USER_MANAGER'),
			// '41' => array("man_id" => '41', "desc" => "用户列表", "url" =>'module/user_manager/user_list_info.php', "man_type"=>'USER_MANAGER'),
			// '42' => array("man_id" => '42', "desc" => "推广用户列表", "url" =>'module/user_manager/agency_wx_user_list.php', "man_type"=>'USER_MANAGER'),
			// '43' => array("man_id" => '43', "desc" => "大师分控制", "url" =>'module/user_manager/master_point_manage.php', "man_type"=>'USER_MANAGER'),

			//充值系统(60~79)		
			// '60' => array("man_id" => '60', "desc" => "充值管理", "url" =>'module/recharge_manager/recharge_order_list.php', "man_type"=>'RECHARGE_MANAGER'),
			// '61' => array("man_id" => '61', "desc" => "流水查询", "url" =>'module/recharge_manager/recharge_query.php', "man_type"=>'RECHARGE_MANAGER'),
			// '62' => array("man_id" => '62', "desc" => "出售钻石(代理)", "url" =>'module/recharge_manager/sell_to_agency_list.php', "man_type"=>'RECHARGE_MANAGER'),
			// '63' => array("man_id" => '63', "desc" => "出售钻石(玩家)", "url" =>'module/recharge_manager/sell_to_user_list.php', "man_type"=>'RECHARGE_MANAGER'),
			//'64' => array("man_id" => '64', "desc" => "玩家自助充值", "url" =>'module/recharge_manager/user_charge_myself.php', "man_type"=>'RECHARGE_MANAGER'),

			//代理系统(80~99)
			// '80' => array("man_id" => '80', "desc" => "生成代理", "url" =>'module/agency_manager/generate_agency.php', "man_type"=>'AGENCY_MANAGER'),
			// '81' => array("man_id" => '81', "desc" => "代理管理", "url" =>'module/agency_manager/agency_list.php', "man_type"=>'AGENCY_MANAGER'),
			// '82' => array("man_id" => '82', "desc" => "代理银行资料", "url" =>'module/agency_manager/agency_bank_info.php', "man_type"=>'AGENCY_MANAGER'),
			// '83' => array("man_id" => '83', "desc" => "代理首页公告", "url" =>'module/agency_manager/agency_index_note.php', "man_type"=>'AGENCY_MANAGER'),
			// '84' => array("man_id" => '84', "desc" => "代理返卡", "url" =>'module/agency_manager/agency_get_dimond_back_log.php', "man_type"=>'AGENCY_MANAGER'),
			// '85' => array("man_id" => '85', "desc" => "代理返现", "url" =>'module/agency_manager/agency_get_money_back_log.php', "man_type"=>'AGENCY_MANAGER'),
			// '86' => array("man_id" => '86', "desc" => "代理房卡调整", "url" =>'module/agency_manager/agency_diamond_change.php', "man_type"=>'AGENCY_MANAGER'),
			// '87' => array("man_id" => '87', "desc" => "房卡调整记录", "url" =>'module/agency_manager/agency_diamond_change_log.php', "man_type"=>'AGENCY_MANAGER'),
			
			//管理员系统(100~119)
			'100' => array("man_id" => '100', "desc" => "管理员管理", "url" =>'module/admin/admin_list.php', "man_type"=>'ADMIN_MANAGER'),
			'101' => array("man_id" => '101', "desc" => "组群管理", "url" =>'module/admin/admin_group_list.php', "man_type"=>'ADMIN_MANAGER'),
			'102' => array("man_id" => '102', "desc" => "参数设置", "url" =>'module/admin/set_values.php', "man_type"=>'ADMIN_MANAGER'),
			// '103' => array("man_id" => '103', "desc" => "线下比赛", "url" =>'module/admin/off_line_play_setting.php', "man_type"=>'ADMIN_MANAGER'),
						
		);
	}

	public function set_session($name, $data, $expire=600){
		$session_data = array();
		$session_data['data'] = $data;
		$session_data['expire'] = time()+$expire;
		$_SESSION[$name] = $session_data;
	}

	public function get_session($name){
		if(isset($_SESSION[$name])){
		    if($_SESSION[$name]['expire']>time()){
		    	return $_SESSION[$name]['data'];
		  	}else{
		    	$this->clear_session($name);
		  	}
		}
		return false;
	}

	public function clear_session($name){
		unset($_SESSION[$name]);
	}
}