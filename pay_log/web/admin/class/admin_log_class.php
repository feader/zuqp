<?php
global $smarty, $db, $auth,$ADMIN_LOG_TYPE,$CLEAR_WEALTH_NUM;

$CLEAR_WEALTH_NUM = -999999999;
$ADMIN_LOG_TYPE = array(
 0 => '显示全部',

 1001 => '封禁帐号',
 1002 => '解封帐号',
 1003 => '封禁IP',
 1004 => '解封IP',
 1005 => '踢玩家下线',
 1006 => '玩家禁言',
 1007 => '玩家解除禁言',
 1008=>  '踢摊位下线',
 1009=>  '送回新手村',
 1010=>  '消除已解禁的禁言记录',
 1011=>  '消除过期已解禁的IP',
 1012=>  '同步IP封禁列表到游戏服',
 1013=>  '初始化玩家属性',
 1014=>  '初始化玩家任务',
 1015=>  '消除变身状态',
 1016=>  '开启竞技场',
 1017=>  '关闭竞技场',
 1018=>  '设置竞技场开启时间',
 1019=>  '开启坐骑竞技',
 1020=>  '关闭坐骑竞技',
 1021=>  '设置坐骑竞技开启时间',
 1022=>  '强制结束比赛',
 1023=>  '开启防沉迷系统',
 1024=>  '关闭防沉迷系统',
 1025=>  '导入新手卡',
 1026=>  '导入活动卡',
 1027=>  '导入帮会义气卡',
 
 2001 => '申请赠送道具',
 2002 => '申请赠送银两',
 2003 => '申请赠送元宝',
 2004 => '充值补单',
 2005 => '按玩家名批量发道具',
 2006 => '按条件批量发道具',
 2007 => '申请清零不绑定元宝',
 2008 => '申请清零绑定元宝',
 2009 => '申请清零银两',
 2010 => '审核并赠送元宝',
 2011 => '审核并赠送银两',
 2012 => '审核并赠送道具',
 2013 => '审核并拒绝赠送元宝',
 2014 => '审核并拒绝赠送银两',
 2015 => '审核并拒绝赠送道具',
 2016 => '审核并清零不绑定元宝',
 2017 => '审核并清零绑定元宝',
 2018 => '审核并清零银两',
 2019 => '通过API赠送元宝',
 2020 => '通过API赠送银两',
 2021 => '通过API赠送道具',
 2022 => '通过API清零绑定元宝',
 2023 => '通过API清零不绑定元宝',
 2024 => '通过API扣除绑定元宝',
 2025 => '通过API扣除不绑定元宝',
 2026 => '申请充值元宝',

 3001 => '消息广播',
 3002 => '给玩家发信',
 3003 => '按玩家名批量发信',
 3004 => '按条件批量发信',
 3005 => '回复玩家投诉',

 4001 => '直接登录玩家帐号',
 4002 => '模拟平台登录帐号',
 4003 => '直接注册GM角色',


 9001 => '登录系统',
 9002 => '修改密码',
 9003 => '添加管理后台用户',
 9011 => '删除管理后台用户',
 9004 => '修改管理后台用户权限',
 9005 => '修改管理后台用户密码',
 9006 => '新增道具权限组',
 9007 => '修改道具权限组',
 9008 => '新建后台权限组',
 9009 => '修改后台权限组',
 9010 => '删除后台权限组',
);

class AdminLogClass
{
	const TYPE_ALL		= 0;		//显示全部

	const TYPE_BAN_USER		= 1001;		//封禁帐号
	const TYPE_UNBAN_USER	= 1002;	//解封帐号
	const TYPE_BAN_IP		= 1003;		//封禁IP
	const TYPE_UNBAN_IP		= 1004;		//解封IP
	const SET_PLAYER_OFF_LINE	= 1005;	//踢玩家下线
	const TYPE_BAN_CHAT		= 1006;		//玩家禁言
	const TYPE_UNBAN_CHAT		= 1007;		//玩家解除禁言
	const TYPE_KICK_STALL	=1008; 		//踢摆摊
	const TYPE_SEND_RETURN_PEACE_VILLAGE	=1009; 		//送回新手村
	const TYPE_CLEAR_OVERDUE_BAN_CHAT	=1010; 		//消除已解禁的禁言记录
	const TYPE_CLEAR_OVERDUE_BAN_IP	=1011; 		//消除过期已解禁的IP
	const TYPE_REWRITE_BAN_IP	=1012; 		//刷新IP封禁列表缓存
	const TYPE_INIT_PROPS       = 1013;   //初始化玩家属性
	const TYPE_INIT_MISSION       = 1014;   //初始化玩家任务
	const TYPE_CHANGE_BODY       = 1015;   //消除变身状态
	const TYPE_OPEN_MATCH       = 1016;    //开启竞技场
	const TYPE_CLOSE_MATCH      = 1017;    //关闭竞技场
	const TYPE_SET_MATCH_TIME   = 1018;    //设置竞技场开启时间
	const TYPE_OPEN_MOUNT_MATCH = 1019;    //开启坐骑竞技
	const TYPE_CLOSE_MOUNT_MATCH= 1020;    //关闭坐骑竞技
	const TYPE_SET_MOUNT_MATCH_TIME = 1021;   //设置坐骑竞技开启时间
	const TYPE_STOP_MATCH    = 1022;        //强制停止坐骑竞技
	const TYPE_OPEN_FCM_SYS    = 1023;     //开启防沉迷系统
	const TYPE_CLOSE_FCM_SYS    = 1024;    //关闭防沉迷系统
	const TYPE_LOAD_CARD        = 1025;    //导入新手卡
	const TYPE_LOAD_FESTIVAL_CARD = 1026; //导入活动卡
	const TYPE_LOAD_FAMILY_CARD = 1027; //导入帮会义气卡

	const TYPE_SEND_GOODS		= 2001;		//赠送道具
	const TYPE_SEND_SILVER		= 2002;		//赠送银两
	const TYPE_SEND_GOLD		= 2003;		//赠送元宝
	const TYPE_DO_ORDERS		= 2004;		//充值补单
	const TYPE_SEND_GOODS_BY_ROLE_NAME	= 2005;		//按玩家名批量发道具
	const TYPE_SEND_GOODS_BY_CONDITION	= 2006;		//按条件批量发道具
	const TYPE_CLEAR_UNBIND_GOLD = 2007;    //清零不绑定元宝
	const TYPE_CLEAR_BIND_GOLD = 2008;   //清零绑定元宝
	const TYPE_CLEAR_SILVER = 2009;     //清零银两
	const TYPE_REVIEW_AND_SEND_GOLD = 2010;  //审核并赠送元宝
	const TYPE_REVIEW_AND_SEND_SILVER = 2011; //审核并赠送银两
	const TYPE_REVIEW_AND_SEND_GOODS = 2012;  //审核并赠送道具
	const TYPE_REVIEW_AND_DENY_SEND_GOLD = 2013;  //审核并拒绝赠送元宝
	const TYPE_REVIEW_AND_DENY_SEND_SILVER = 2014;  //审核并拒绝赠送银两
	const TYPE_REVIEW_AND_DENY_SEND_GOODS = 2015;  //审核并拒绝赠送道具
	const TYPE_REVIEW_AND_CLEAR_UNBIND_GOLD = 2016;  //审核并清除不绑定元宝
	const TYPE_REVIEW_AND_CLEAR_BIND_GOLD = 2017; //审核并清除绑定元宝
	const TYPE_REVIEW_AND_CLEAR_SILVER = 2018; //审核并清除银两
	const TYPE_API_SEND_GOLD = 2019; //通过API赠送元宝
	const TYPE_API_SEND_SILVER = 2020; //通过API赠送银两
	const TYPE_API_SEND_ITEM = 2021; //通过API赠送道具
	const TYPE_API_CLEAR_BIND_GOLD = 2022; //通过API清零绑定元宝
	const TYPE_API_CLEAR_UNBIND_GOLD = 2023; //通过API清零不绑定元宝
	const TYPE_API_DEDUCT_BIND_GOLD = 2024; //通过API扣除绑定元宝
	const TYPE_API_DEDUCT_UNBIND_GOLD = 2025; //通过API扣除不绑定元宝
	const TYPE_PAY_GOLD = 2026; //模拟充值&赠送元宝

	const TYPE_MSG_BROADCAST	= 3001;		//消息广播
	const TYPE_SEND_EMAIL	= 3002;		//给玩家发信
	const TYPE_SEND_EMAIL_BY_ROLE_NAME	= 3003;		//按玩家名批量发信
	const TYPE_SEND_EMAIL_BY_CONDITION	= 3004;		//按条件批量发信
	const TYPE_REPLY_COMPLAINT          = 3005;     //回复玩家投诉

	const TYPE_DIRECT_LOGIN_USER		= 4001;		//直接登录玩家帐号
	const TYPE_DIRECT_LOGIN_PLATFORM	= 4002;		//模拟平台登录帐号
	const TYPE_CREATE_GM_ROLE			= 4003;		//直接注册GM角色


	const TYPE_SYS_LOGIN			= 9001;			//登录系统
	const TYPE_SYS_SET_PASSWORD		= 9002;		//修改自己密码
	const TYPE_SYS_CREATE_ADMIN		= 9003;		//添加后台用户
	const TYPE_SYS_DELETE_ADMIN		= 9011;		//删除后台用户
	const TYPE_SYS_MODIFY_ADMIN		= 9004;		//修改用户权限
	const TYPE_SYS_MODIFY_ADMIN_PASSWORD		= 9005;		//修改后台用户密码
	const TYPE_SYS_CREATE_ITEM_GOOP				= 9006;		//新增道具权限组
	const TYPE_SYS_MODIFY_ITEM_GOOP				= 9007;		//修改道具权限组
	const TYPE_SYS_CREATE_ADMIN_GROUP		= 9008;		//新建用户组
	const TYPE_SYS_MODIFY_ADMIN_GROUP		= 9009;		//修改用户组
	const TYPE_SYS_DELETE_ADMIN_GROUP		= 9010;		//删除用户组


	var $userid;
	var $username;

    var $key;

	function __construct()
 	{
 		global $auth;
		$this->userid    = $auth->userid();
		$this->username  = $auth->username();
 		//assert(is_int($ADMIN->userid) && $ADMIN->userid > 0);
 	}

	function __destruct()
	{
	}

	//使用金币
	// $type 的取值根据 $ADMIN_LOG_TYPE 数组
	// $detail 与 $type 匹配，如果使用赠送道具，则$detail为道具的ID
	// $number 为具体的数量，比如赠送金币的数量
	// $desc 为中文的详细描述，如“赠送道具”，“赠送金币”
	// $user_id, $user_name为被操作对象
	public function Log($type, $detail, $number=0, $desc="", $user_id=0, $user_name="")
	{
		$f['admin_id']   = $this->userid;
		$f['admin_name'] = $this->username;
		$f['admin_ip']   = GetIP();
		
		if($user_id == '')
			$user_id = 0;

		$f['user_id']    = $user_id;
		$f['user_name']  = $user_name;

		$f['mtime']    = time();
		$f['mtype']    = $type;
		$f['mdetail']  = $detail;
		if($number == '')
			$number = 0;
		$f['number']   = $number;
		if (!empty($desc))
		    $f['desc']     = $desc;
		else {
		    global $ADMIN_LOG_TYPE;
		    $f['desc']     = $ADMIN_LOG_TYPE[$type];
		}
		global $dbConfig;
		$sql = 'INSERT INTO `'.$dbConfig['dbname'].'`.`t_log_admin` (`admin_id`, `admin_name`, `admin_ip`, `user_id`, `user_name`,`mtime`,`mtype`,`mdetail`,`number`,`desc`)' .
				' VALUES (\'' .$f['admin_id'].'\',\'' .$f['admin_name'].'\', \'' .$f['admin_ip'].'\', \'' .$f['user_id'].'\', \'' .$f['user_name'].'\', \'' .$f['mtime'].'\', \'' .$f['mtype'].'\', \'' .$f['mdetail'].'\', \'' .$f['number'].'\', \'' .$f['desc'].'\');';
		global $db ;
		$db->query($sql);
	}
	
	//历史记录
	public function getLogs($start = 0, $end = 0, $admin_name = '', $type = 0)
	{
		global $_DCACHE;
		$sql = "SELECT * FROM ".T_LOG_ADMIN." WHERE 1 ";
		if ($admin_name)
			$sql .= " AND `admin_name`='{$admin_name}'";
		if ($start)
			$sql .= " AND `mtime` >= {$start}";
		if ($end)
			$sql .= " AND `mtime` <= {$end}";
		if ($type>0)
			$sql .= " AND mtype='{$type}'";

		$sql .= " ORDER BY `mtime` DESC";
		$rs = $db->FetchRowSet($sql);

		if(!is_array($rs))
			$rs = array();

		//var_dump($sql);

		for($i = 0; $i < count($rs); $i++)
		{
			if($rs[$i]['mtime'])
				$rs[$i]['time_str'] = strftime('%D %T', $rs[$i]['mtime']);

			$mtype = $rs[$i]['mtype'];
			$str = '';
			if($rs[$i]['mdetail'])
			{
				if($mtype == 5)
				{
					$res = extractData($rs[$i]['mdetail']);
					if(intval($res['W']))
						$str .= '木: ' .intval($res['W']);
					if(intval($res['M']))
						$str .= '  铁: ' .intval($res['M']);
					if(intval($res['F']))
						$str .= '  粮: ' .intval($res['F']);
				}
				elseif($mtype == 2)
				{
					$tid = $rs[$i]['mdetail'];
					$tname = $_DCACHE['tech'][$tid]['name'];
					$str .= $tname;

				}
				elseif($mtype == 1)
				{
					$bid = $rs[$i]['mdetail'];
					$bname = $_DCACHE['building'][$bid]['name'];
					$str .= $bname;
				}
				elseif($mtype == 3)
				{
					$sid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$sname = $_DCACHE['soldier'][$sid]['name'];
					//$str .= $sname . ' ' . $num . '个';
				}
				elseif($mtype == 4)
				{
					$iid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$iname = $_DCACHE['item'][$iid]['name'];
					//$str .= $iname . ' ' . $num . '个';
				}
			}
			if($mtype == 6)
			{
				$num = $rs[$i]['number'];
				if($rs[$i]['desc']=='赠送元宝')
				{
					$str .= '赠送'.$num.' 元宝';
				}
				elseif($rs[$i]['desc']=='赠送金砖')
				{
					$str .= '赠送'.$num.' 金砖';
				}
				//else $str .= $num.' 元宝';
			}
			elseif($mtype == 92)
			{
				$admin_level = $rs[$i]['number'];
				$pos = strpos($rs[$i]['mdetail'],'权限组');
				if($pos === false)
				{
					$str .= '级别 '.$admin_level;
				}
			}
			$rs[$i]['mdetail_str'] = $str;
		}

		return $rs;
	}

	/*
	 * 取得有过滤条件的数据
	 */
	public function getGlvLogs($start = 0, $end = 0, $admin_name = '', $gulvxt, $op_type, $type = 0)
	{
		global $_DCACHE;
		$sql = "SELECT * FROM t_log_admin WHERE 1 ";
		if ($admin_name)
			$sql .= " AND `admin_name`='{$admin_name}'";
		if ($gulvxt)
			$sql .= " AND `mtype` <> '{$gulvxt}'";
		if ($op_type != '0')
			$sql .= " AND `mtype`= '{$op_type}'";
		if ($start)
			$sql .= " AND `mtime` >= {$start}";
		if ($end)
			$sql .= " AND `mtime` <= {$end}";
		if ($type>0)
			$sql .= " AND mtype='{$type}'";


		$sql .= " ORDER BY `mtime` DESC";
		global $db;
		$rs = $db->FetchAll($sql);

		if(!is_array($rs))
			$rs = array();

		//var_dump($sql);

		for($i = 0; $i < count($rs); $i++)
		{
			if($rs[$i]['mtime'])
				$rs[$i]['time_str'] = strftime('%D %T', $rs[$i]['mtime']);

			$mtype = $rs[$i]['mtype'];
			$str = '';
			if($rs[$i]['mdetail'])
			{
				if($mtype == 5)
				{
					$res = extractData($rs[$i]['mdetail']);
					if(intval($res['W']))
						$str .= '木: ' .intval($res['W']);
					if(intval($res['M']))
						$str .= '  铁: ' .intval($res['M']);
					if(intval($res['F']))
						$str .= '  粮: ' .intval($res['F']);
				}
				elseif($mtype == 2)
				{
					$tid = $rs[$i]['mdetail'];
					$tname = $_DCACHE['tech'][$tid]['name'];
					$str .= $tname;

				}
				elseif($mtype == 1)
				{
					$bid = $rs[$i]['mdetail'];
					$bname = $_DCACHE['building'][$bid]['name'];
					$str .= $bname;
				}
				elseif($mtype == 3)
				{
					$sid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$sname = $_DCACHE['soldier'][$sid]['name'];
					//$str .= $sname . ' ' . $num . '个';
				}
				elseif($mtype == 4)
				{
					$iid = $rs[$i]['mdetail'];
					$num = $rs[$i]['number'];
					$iname = $_DCACHE['item'][$iid]['name'];
					//$str .= $iname . ' ' . $num . '个';
				}
			}
			if($mtype == 6)
			{
				$num = $rs[$i]['number'];
				if($rs[$i]['desc']=='赠送元宝')
				{
					$str .= '赠送'.$num.' 元宝';
				}
				elseif($rs[$i]['desc']=='赠送金砖')
				{
					$str .= '赠送'.$num.' 金砖';
				}
				//else $str .= $num.' 元宝';
			}
			elseif($mtype == 92)
			{
				$admin_level = $rs[$i]['number'];
				$pos = strpos($rs[$i]['mdetail'],'权限组');
				if($pos === false)
				{
					$str .= '级别 '.$admin_level;
				}
			}
			$rs[$i]['mdetail_str'] = $str;
		}

		return $rs;
	}

	/**
	 * 记录管理员批量赠送道具
	 *
	 * @param string $detail
	 */
	public function logBatchSendItem($detail)
	{
	    $this->Log(9, '', 0, $detail);
	}
	
	public function ReviewLog($type, $detail, $number, $desc, $user_id, $user_name, $item_name, $item_id, $goods_name='', $bind, $reason)
	{
		$f['admin_id']   = $this->userid;
		$f['admin_name'] = $this->username;
		$f['admin_ip']   = GetIP();

		$f['user_id']    = $user_id;
		$f['user_name']  = $user_name;

		$f['mtime']    = time();
		$f['mtype']    = $type;
		$f['mdetail']  = $detail;
		$f['number']   = $number;
		if (!empty($desc))
		    $f['desc']     = $desc;
		else {
		    global $ADMIN_LOG_TYPE;
		    $f['desc']     = $ADMIN_LOG_TYPE[$type];
		}
		
		$f['item_name'] = $item_name;
		$f['item_id'] = $item_id;
		$f['goods_name'] = $goods_name;
		$f['bind'] = $bind;
		$f['reason'] = $reason;
		$f['status'] = '1';
		$f['review_admin_id'] = '';
		$f['review_admin_ip'] = '';
		$f['review_admin_name'] = '';
		$f['review_mtime'] = '';
		
		global $dbConfig;
		$sql = 'INSERT INTO `'.$dbConfig['dbname'].'`.`t_log_review` (`admin_id`, `admin_name`, `admin_ip`, `user_id`, `user_name`,`mtime`,`mtype`,`mdetail`,`number`,`desc`,' .
				'`item_name`, `item_id`, `goods_name`, `bind`, `reason`, `status`, `review_admin_id`, `review_admin_name`, `review_admin_ip`, `review_mtime`)' .
				' VALUES (\'' .$f['admin_id'].'\',\'' .$f['admin_name'].'\', \'' .$f['admin_ip'].'\', \'' .$f['user_id'].'\', \'' .$f['user_name'].'\', \'' .$f['mtime'].'\', \'' .$f['mtype'].'\', \'' .$f['mdetail'].'\', \'' .$f['number'].'\', \'' .$f['desc'].'\',  \'' .$f['item_name'].'\', \'' .$f['item_id'].'\', \'' .$f['goods_name'].'\', \'' .$f['bind'].'\', \'' .$f['reason'].'\', \'' .$f['status'].'\', \'' .$f['review_admin_id'].'\', \'' .$f['review_admin_name'].'\', \'' .$f['review_admin_ip'].'\', \'' .$f['review_mtime'].'\');';
		global $db ;
		$db->query($sql);
	}
	
	public function getReviewLog($dateStartStamp=0, $dateEndStamp=0, $apply_admin_name='', $review_admin_name='', $status_id=0, $item_name='', $clear_type='')
	{
		$sql = "SELECT * FROM t_log_review WHERE 1";
		if ($apply_admin_name)
			$sql .= " AND `admin_name`='{$apply_admin_name}'";
		if ($review_admin_name)
			$sql .= " AND `review_admin_name`='{$review_admin_name}'";
		if ($dateStartStamp)
			$sql .= " AND `mtime` >= {$dateStartStamp}";
		if ($dateEndStamp)
			$sql .= " AND `mtime` <= {$dateEndStamp}";
		if ($status_id != '0')
			$sql .= " AND `status`= '{$status_id}'";
		if ($item_name)
			$sql .= " AND (`item_name`='{$item_name}'";
		if ($clear_type)
			$sql .= " OR `item_name` LIKE '%{$clear_type}%'";
		if ($item_name == 'item')
		{
			$sql .= " OR `item_name`='send_item' OR `item_name`='send_stone' OR `item_name`='send_equip' OR `item_name`='send_pet' OR `item_name`='send_mount' OR `item_name`='send_mount_equip' OR `item_name`='send_treasure' OR `item_name`='send_treasure_part' OR `item_name`='send_seal' OR `item_name`='send_pet_equip' OR `item_name`='send_equip_magic'";
		}
		if ($item_name == 'send_gold')
		{
			$sql .= " OR `item_name` = 'pay_gold'";
		}
		if ($item_name)
			$sql .= ")";
		$sql .= " AND `mtype` != 2021";
		$sql .= " ORDER BY `id` desc";
		global $db;
		$rs = $db->FetchAll($sql);
		return $rs;
		
	}
	
	public function getReviewItemLog($dateStartStamp=0, $dateEndStamp=0, $apply_admin_name='', $review_admin_name='', $status_id=0, $item_name='', $clear_type='')
	{
		$sql = "SELECT * FROM t_log_review WHERE 1";
		if ($apply_admin_name)
			$sql .= " AND `admin_name`='{$apply_admin_name}'";
		if ($review_admin_name)
			$sql .= " AND `review_admin_name`='{$review_admin_name}'";
		if ($dateStartStamp)
			$sql .= " AND `mtime` >= {$dateStartStamp}";
		if ($dateEndStamp)
			$sql .= " AND `mtime` <= {$dateEndStamp}";
		if ($status_id != '0')
			$sql .= " AND `status`= '{$status_id}'";
		if ($item_name)
			$sql .= " AND (`item_name`='{$item_name}'";
		if ($clear_type)
			$sql .= " OR `item_name` LIKE '%{$clear_type}%'";
		if ($item_name == 'item')
		{
			$sql .= " OR `item_name`='send_item' OR `item_name`='send_stone' OR `item_name`='send_equip' OR `item_name`='send_pet' OR `item_name`='send_mount' OR `item_name`='send_mount_equip' OR `item_name`='send_treasure' OR `item_name`='send_treasure_part' OR `item_name`='send_seal' OR `item_name`='send_pet_equip' OR `item_name`='send_equip_magic'";
		}
		if ($item_name == 'send_gold')
		{
			$sql .= " OR `item_name` = 'pay_gold'";
		}
		if ($item_name)
			$sql .= ")";
		$sql .= " AND `mtype` != 2021";
		$sql .= " ORDER BY `id` desc";
		global $db;
		$rs = $db->FetchAll($sql);
		return $rs;
		
	}
	
	public function updateReviewLog($id, $status)
	{
		$review_admin_id   = $this->userid;
		$review_admin_name = $this->username;
		$review_admin_ip   = GetIP();
		$review_time = time();
		global $dbConfig;
		$sql = 'UPDATE `'.$dbConfig['dbname'].'`.`t_log_review` SET `status` = \'' .
				$status .
				'\', `review_admin_id` = \'' .
				$review_admin_id .
				'\', `review_admin_name` = \'' .
				$review_admin_name .
				'\', `review_admin_ip` = \'' .
				$review_admin_ip .
				'\', `review_mtime` = \'' .
				$review_time .
				'\' WHERE `t_log_review`.`id` = ' .
				$id .
				' LIMIT 1;'; 
		global $db ;
		$db->query($sql);
	}
}