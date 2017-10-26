-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-10-26 14:21:10
-- 服务器版本： 10.0.23-MariaDB-log
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yxpdk`
--

-- --------------------------------------------------------

--
-- 替换视图以便查看 `agency_to_ip_user`
--
CREATE TABLE IF NOT EXISTS `agency_to_ip_user` (
`id` int(10)
,`agency_id` varchar(20)
,`action_time` int(11)
,`uid` int(64)
,`username` varchar(64)
,`dimond` int(11) unsigned
,`sum_dimond` int(11) unsigned
,`reg_ip` varchar(50)
);

-- --------------------------------------------------------

--
-- 替换视图以便查看 `agency_to_wx_user`
--
CREATE TABLE IF NOT EXISTS `agency_to_wx_user` (
`id` int(10)
,`agency_id` varchar(20)
,`unionid` varchar(50)
,`action_time` int(11)
,`uid` int(64)
,`username` varchar(64)
,`register_time` int(11) unsigned
,`dimond` int(11) unsigned
,`sum_dimond` int(11) unsigned
);

-- --------------------------------------------------------

--
-- 表的结构 `t_admin_group`
--

CREATE TABLE IF NOT EXISTS `t_admin_group` (
  `group_id` int(11) unsigned NOT NULL,
  `power` text NOT NULL,
  `desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_admin_log`
--

CREATE TABLE IF NOT EXISTS `t_admin_log` (
  `id` int(10) unsigned NOT NULL,
  `admin_id` varchar(50) NOT NULL,
  `action_type` int(11) unsigned NOT NULL,
  `action_time` int(11) unsigned NOT NULL,
  `admin_ip` varchar(128) NOT NULL,
  `action_arg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_admin_user`
--

CREATE TABLE IF NOT EXISTS `t_admin_user` (
  `uid` int(10) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `gid` int(10) NOT NULL COMMENT '群组id',
  `last_login_time` int(11) NOT NULL,
  `agent_id` text NOT NULL COMMENT '代理商ID',
  `admin_desc` text COMMENT '账户描述'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_agency`
--

CREATE TABLE IF NOT EXISTS `t_agency` (
  `id` int(10) unsigned NOT NULL,
  `uid` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `unionid` varchar(50) NOT NULL,
  `grade` tinyint(3) unsigned NOT NULL,
  `uber_agency` varchar(50) NOT NULL COMMENT '上级代理',
  `nick_name` varchar(50) NOT NULL DEFAULT '',
  `note` varchar(100) DEFAULT NULL COMMENT '备注',
  `register_time` int(11) unsigned NOT NULL,
  `phone_number` varchar(11) NOT NULL DEFAULT '',
  `recharge_dimond` int(11) unsigned NOT NULL DEFAULT '0',
  `recharge_send_dimond` int(11) unsigned NOT NULL DEFAULT '0',
  `recharge_money` int(11) unsigned NOT NULL DEFAULT '0',
  `first_login_time` int(11) NOT NULL COMMENT '首次登陆时间',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0',
  `last_login_ip` varchar(128) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_agency_and_user`
--

CREATE TABLE IF NOT EXISTS `t_agency_and_user` (
  `id` int(10) NOT NULL,
  `agency_id` varchar(20) NOT NULL COMMENT '代理uid',
  `unionid` varchar(50) NOT NULL COMMENT '微信用户unionid',
  `agent_ip` varchar(50) NOT NULL,
  `action_time` int(11) NOT NULL COMMENT '插入记录时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_agency_bank_info`
--

CREATE TABLE IF NOT EXISTS `t_agency_bank_info` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) NOT NULL COMMENT '代理的uid',
  `weixin` varchar(50) NOT NULL COMMENT '微信',
  `alipay` varchar(50) NOT NULL COMMENT '支付宝',
  `opening_bank` varchar(50) NOT NULL COMMENT '开户行',
  `branch` varchar(100) NOT NULL COMMENT '分行',
  `bank_name` varchar(20) NOT NULL COMMENT '开户名',
  `bank_account` varchar(100) NOT NULL COMMENT '开户账号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_agency_diamond_change_log`
--

CREATE TABLE IF NOT EXISTS `t_agency_diamond_change_log` (
  `id` int(11) NOT NULL,
  `auid` char(11) NOT NULL,
  `diamond` char(10) NOT NULL,
  `handler` char(10) NOT NULL,
  `create_time` int(11) NOT NULL,
  `note` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_agency_get_dimond_back_log`
--

CREATE TABLE IF NOT EXISTS `t_agency_get_dimond_back_log` (
  `id` int(11) NOT NULL,
  `auid` varchar(50) NOT NULL COMMENT '推广代理的uid',
  `buid` varchar(50) NOT NULL COMMENT '购买者的uid（玩家或代理）',
  `buyername` varchar(50) NOT NULL COMMENT '购买的名字（玩家呢称/代理uid）',
  `utype` int(1) NOT NULL COMMENT '1是玩家，2是代理',
  `buy_dimond_num` int(11) NOT NULL COMMENT '购买的房卡（钻石）数',
  `dimond_back_num` int(11) NOT NULL COMMENT '返的房卡（钻石）',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_agency_sell_to_agency`
--

CREATE TABLE IF NOT EXISTS `t_agency_sell_to_agency` (
  `id` int(10) NOT NULL,
  `sell_agency_uid` varchar(64) DEFAULT NULL,
  `buy_agency_uid` varchar(64) DEFAULT NULL,
  `dimond_num` int(10) DEFAULT NULL,
  `sell_agency_owned_diamond` int(11) DEFAULT NULL,
  `sell_agency_now_diamond` int(11) DEFAULT NULL,
  `buy_agency_owned_diamond` int(11) DEFAULT NULL,
  `buy_agency_now_diamond` int(11) DEFAULT NULL,
  `create_time` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_ban_log`
--

CREATE TABLE IF NOT EXISTS `t_ban_log` (
  `id` int(10) NOT NULL,
  `action_time` int(11) NOT NULL COMMENT '动作时间',
  `action_type` int(1) NOT NULL COMMENT '动作类型0是默认，1是封，2是解',
  `handler` varchar(50) NOT NULL COMMENT '操作者',
  `uid` varchar(100) NOT NULL COMMENT '玩家id',
  `content` varchar(50) NOT NULL COMMENT '动作描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_data_count`
--

CREATE TABLE IF NOT EXISTS `t_data_count` (
  `id` int(1) NOT NULL,
  `data_time` varchar(50) NOT NULL,
  `register` int(11) NOT NULL,
  `total_charge_money` varchar(14) NOT NULL,
  `total_cost_dimond` int(11) NOT NULL,
  `acu` float(4,1) NOT NULL COMMENT '日平均在线人数',
  `aacu` float(4,1) NOT NULL COMMENT '实时平均在线人数',
  `uv` float(4,1) NOT NULL COMMENT '当日登录帐号数',
  `pu` float(4,1) NOT NULL COMMENT '付费用户数：充值付费过的用户',
  `all_reg` int(10) NOT NULL COMMENT '历史注册总量',
  `dau` float(4,1) NOT NULL COMMENT '日活跃用户数',
  `dau_apa` int(10) NOT NULL COMMENT '日活跃付费账号',
  `mau` float(4,1) NOT NULL COMMENT '月活跃用户数',
  `mau_apa` int(10) NOT NULL COMMENT '月活跃付费账号',
  `dts` float(10,1) NOT NULL COMMENT '用户平均在线时长（日）',
  `dul` float(4,1) NOT NULL COMMENT '日用户流失率',
  `mul` float(4,1) NOT NULL COMMENT '月用户流失率',
  `rhyl` float(4,1) NOT NULL COMMENT '活跃率',
  `marpu` int(10) NOT NULL COMMENT '月付费用户',
  `darpu` int(10) NOT NULL COMMENT '日付费用户',
  `dau_reg_ffl` float(4,1) NOT NULL COMMENT '日注册用户付费率',
  `dau_avg_online_ffl` float(4,1) NOT NULL COMMENT '日平均在线付费率',
  `dau_nv_ffl` float(4,1) NOT NULL COMMENT '日活跃用户付费率',
  `mau_reg_ffl` float(4,1) NOT NULL COMMENT '月注册用户付费率',
  `mau_avg_online_ffl` float(4,1) NOT NULL COMMENT '月平均在线付费率',
  `mau_nv_ffl` float(4,1) NOT NULL COMMENT '月活跃用户付费率',
  `au` int(10) NOT NULL COMMENT '当日登录帐号数',
  `second_retention` float(10,2) NOT NULL,
  `third_retention` float(10,2) NOT NULL,
  `fourth_retention` float(10,2) NOT NULL,
  `fifth_retention` float(10,2) NOT NULL,
  `sixth_retention` float(10,2) NOT NULL,
  `seventh_retention` float(10,2) NOT NULL,
  `fourteenth_retention` float(10,2) NOT NULL,
  `thirty_retention` float(10,2) NOT NULL,
  `create_time` int(11) NOT NULL,
  `action_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_dimond_log`
--

CREATE TABLE IF NOT EXISTS `t_dimond_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `change_num` int(11) NOT NULL,
  `change_bind_num` int(11) NOT NULL,
  `remain_num` int(11) NOT NULL,
  `remain_bind_num` int(11) unsigned NOT NULL,
  `action_type` int(11) unsigned NOT NULL,
  `action_time` int(11) unsigned NOT NULL,
  `action_arg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_everyday_online_time_log`
--

CREATE TABLE IF NOT EXISTS `t_everyday_online_time_log` (
  `id` int(1) NOT NULL,
  `uid` int(11) NOT NULL,
  `everyday_online_time` int(11) NOT NULL COMMENT '每天在线时间总和（秒）',
  `create_time` int(11) NOT NULL,
  `date_time` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_everyday_total_dimond_log`
--

CREATE TABLE IF NOT EXISTS `t_everyday_total_dimond_log` (
  `id` int(11) NOT NULL,
  `date_time` varchar(50) DEFAULT NULL,
  `today_total_dimond` int(10) DEFAULT NULL,
  `write_time` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_everyday_user_dimond_log`
--

CREATE TABLE IF NOT EXISTS `t_everyday_user_dimond_log` (
  `id` int(11) NOT NULL,
  `date_time` varchar(50) DEFAULT NULL,
  `everyday_total_use` int(10) DEFAULT NULL,
  `write_time` int(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_every_month_money_back`
--

CREATE TABLE IF NOT EXISTS `t_every_month_money_back` (
  `id` int(11) NOT NULL,
  `auid` varchar(50) NOT NULL COMMENT '代理uid',
  `back_money` float NOT NULL COMMENT '返现金额',
  `back_date` varchar(50) NOT NULL COMMENT '返现日期',
  `back_create_time` int(11) NOT NULL COMMENT '创建时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '是否结算',
  `back_time` int(11) NOT NULL COMMENT '发放时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_gamer_get_dimond_log`
--

CREATE TABLE IF NOT EXISTS `t_gamer_get_dimond_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '推广玩家uid',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '领取状态(0是有可领取，1是已领取)',
  `reward_dimond` int(11) NOT NULL COMMENT '可房卡（钻石）数',
  `get_time` int(11) NOT NULL COMMENT '领取时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_gamer_to_gamer`
--

CREATE TABLE IF NOT EXISTS `t_gamer_to_gamer` (
  `id` int(11) NOT NULL,
  `fuid` int(11) NOT NULL COMMENT '推广用户的uid',
  `suid` int(11) NOT NULL COMMENT '受邀请用户的uid',
  `unionid` varchar(100) NOT NULL COMMENT '受邀请用户的微信openid',
  `create_time` int(11) NOT NULL COMMENT '记录生成时间',
  `first_login_time` int(11) NOT NULL COMMENT '受邀用户首次登陆时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_game_room_log`
--

CREATE TABLE IF NOT EXISTS `t_game_room_log` (
  `id` int(1) NOT NULL,
  `room_id` int(11) NOT NULL COMMENT '房间ID',
  `room_master` int(11) DEFAULT NULL,
  `room_type` int(1) NOT NULL DEFAULT '1',
  `uids` varchar(100) NOT NULL,
  `action_time` int(11) NOT NULL COMMENT '记录时间',
  `finish_time` int(11) NOT NULL COMMENT '结束时间',
  `play_times` char(10) DEFAULT NULL COMMENT '一局里打了多少盘'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_game_user`
--

CREATE TABLE IF NOT EXISTS `t_game_user` (
  `id` int(11) NOT NULL,
  `uid` int(64) NOT NULL COMMENT '用户id',
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `openid` varchar(30) DEFAULT NULL COMMENT '微信openid',
  `unionid` varchar(50) DEFAULT NULL,
  `register_time` int(11) unsigned NOT NULL COMMENT '注册时间',
  `dimond` int(11) unsigned NOT NULL COMMENT '余额',
  `sum_dimond` int(11) unsigned NOT NULL COMMENT '累计充值',
  `total_play_times` int(11) NOT NULL COMMENT '总玩牌数',
  `last_login_time` bigint(20) DEFAULT NULL COMMENT '上次登陆时间',
  `last_dimond_charge_time` bigint(20) DEFAULT NULL COMMENT '最近充值时间',
  `reg_ip` varchar(50) DEFAULT NULL COMMENT '账号注册ip',
  `invite_id` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL COMMENT '操作系统'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_game_user_login_log`
--

CREATE TABLE IF NOT EXISTS `t_game_user_login_log` (
  `id` int(1) NOT NULL,
  `uid` varchar(11) NOT NULL COMMENT '玩家uid',
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `create_time` int(11) NOT NULL COMMENT '玩家账号创建时间',
  `action` char(10) DEFAULT NULL COMMENT '动作类型',
  `online_time` int(11) NOT NULL COMMENT '在线时间',
  `last_login_time` int(11) NOT NULL COMMENT '玩家最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录ip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_group`
--

CREATE TABLE IF NOT EXISTS `t_group` (
  `gid` int(10) NOT NULL COMMENT '群组id',
  `name` varchar(50) NOT NULL COMMENT '群组名',
  `power` text NOT NULL COMMENT '群组权限',
  `remark` varchar(200) DEFAULT '请填写群组描述' COMMENT '群组描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_money_back_log`
--

CREATE TABLE IF NOT EXISTS `t_money_back_log` (
  `id` int(11) NOT NULL,
  `auid` varchar(50) NOT NULL COMMENT '代理uid',
  `pay_person_num` int(11) NOT NULL COMMENT '推广出来有消费的玩家数',
  `pay_person_dimond_num` int(11) NOT NULL COMMENT '有消费玩家总消费的房卡（钻石）数',
  `get_money` float NOT NULL COMMENT '奖励金额',
  `get_money_time` int(11) NOT NULL COMMENT '统计日期',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '当月推荐玩家消耗的房卡（钻石）是否翻卡（钻）',
  `handle_time` int(11) DEFAULT NULL COMMENT '发放时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_offlineplay_sign_sort`
--

CREATE TABLE IF NOT EXISTS `t_offlineplay_sign_sort` (
  `id` int(11) NOT NULL,
  `unionid` varchar(100) NOT NULL,
  `sign_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_offline_play`
--

CREATE TABLE IF NOT EXISTS `t_offline_play` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `unionid` varchar(100) NOT NULL COMMENT '微信openid',
  `sign` int(1) NOT NULL DEFAULT '0' COMMENT '是否签到',
  `sign_sort` int(11) NOT NULL COMMENT '签到序号',
  `sign_time` int(11) NOT NULL COMMENT '签到时间',
  `create_time` int(11) NOT NULL COMMENT '报名时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_offline_play_setting`
--

CREATE TABLE IF NOT EXISTS `t_offline_play_setting` (
  `id` int(11) NOT NULL,
  `start_time` int(11) NOT NULL COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL COMMENT '活动结束时间',
  `join_point` int(11) NOT NULL COMMENT '报名积分'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_online_count_log`
--

CREATE TABLE IF NOT EXISTS `t_online_count_log` (
  `id` int(11) unsigned NOT NULL,
  `online_count` int(11) unsigned NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `year` int(11) unsigned NOT NULL,
  `month` int(11) unsigned NOT NULL,
  `week` int(11) unsigned NOT NULL,
  `day` int(11) unsigned NOT NULL,
  `hour` int(11) unsigned NOT NULL,
  `min` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_online_log`
--

CREATE TABLE IF NOT EXISTS `t_online_log` (
  `id` int(10) NOT NULL,
  `online` int(10) unsigned NOT NULL COMMENT '在线数量',
  `dateline` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='玩家在线日志表';

-- --------------------------------------------------------

--
-- 表的结构 `t_recharge_log`
--

CREATE TABLE IF NOT EXISTS `t_recharge_log` (
  `id` int(10) unsigned NOT NULL,
  `order_id` varchar(200) DEFAULT NULL,
  `alipay_order_id` varchar(100) DEFAULT NULL,
  `order_status` tinyint(4) unsigned DEFAULT '0' COMMENT '订单状态（TRADE_SUCCESS:1, TRADE_FINISHED:2）',
  `uid` varchar(50) DEFAULT NULL,
  `dimond_number` int(11) unsigned DEFAULT NULL,
  `money_number` int(11) unsigned DEFAULT NULL,
  `gift_dimond_number` int(11) unsigned DEFAULT NULL,
  `action_time` int(11) unsigned DEFAULT NULL,
  `create_time` int(10) unsigned DEFAULT NULL COMMENT '订单创建时间',
  `success_time` int(10) unsigned DEFAULT NULL COMMENT '订单Success时间',
  `finish_time` int(10) unsigned DEFAULT NULL COMMENT '订单完成时间',
  `desc` varchar(255) DEFAULT NULL,
  `pay_way` char(20) NOT NULL DEFAULT 'alipay' COMMENT '支付方式'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_sell_log`
--

CREATE TABLE IF NOT EXISTS `t_sell_log` (
  `id` int(10) unsigned NOT NULL COMMENT '代理等级',
  `seller_uid` varchar(50) NOT NULL,
  `buyer_uid` varchar(50) NOT NULL,
  `buyer_type` tinyint(3) unsigned DEFAULT NULL,
  `buyer_nickname` varchar(50) DEFAULT '',
  `buyer_name` varchar(50) DEFAULT NULL,
  `agency_owned_diamond` int(11) DEFAULT NULL,
  `agency_now_diamond` int(11) DEFAULT NULL,
  `user_owned_diamond` int(11) DEFAULT NULL,
  `user_now_diamond` int(11) DEFAULT NULL,
  `dimond_num` int(11) unsigned NOT NULL,
  `action_time` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_system_setting`
--

CREATE TABLE IF NOT EXISTS `t_system_setting` (
  `id` int(10) NOT NULL,
  `setting_name` char(100) NOT NULL COMMENT '参数名',
  `setting_value` text NOT NULL COMMENT '具体信息',
  `value_introduce` char(100) NOT NULL COMMENT '参数名字解释'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_test_log`
--

CREATE TABLE IF NOT EXISTS `t_test_log` (
  `id` int(11) NOT NULL,
  `text_conent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_user_charge_from_agency`
--

CREATE TABLE IF NOT EXISTS `t_user_charge_from_agency` (
  `id` int(11) NOT NULL,
  `uid` char(20) NOT NULL,
  `auid` char(20) NOT NULL,
  `price` char(10) NOT NULL,
  `diamond` int(10) NOT NULL,
  `create_time` int(11) NOT NULL,
  `give_time` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0是未体现，1是已提现'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_user_charge_order`
--

CREATE TABLE IF NOT EXISTS `t_user_charge_order` (
  `id` int(11) NOT NULL,
  `uid` varchar(11) NOT NULL COMMENT '玩家uid',
  `trade_no` varchar(30) NOT NULL COMMENT '交易订单号',
  `order_sn` varchar(20) NOT NULL COMMENT '内部订单id',
  `transaction_id` varchar(30) NOT NULL,
  `price` float(5,2) NOT NULL COMMENT '交易金额',
  `dimond` int(11) NOT NULL COMMENT '房卡（钻石）',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `create_time` int(11) NOT NULL COMMENT '生成时间',
  `finish_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `wx_back_info` varchar(180) NOT NULL COMMENT '微信回调的信息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_user_complain`
--

CREATE TABLE IF NOT EXISTS `t_user_complain` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL COMMENT '玩家id',
  `contact_way` varchar(100) NOT NULL COMMENT '联系方式',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `content` text NOT NULL COMMENT '内容',
  `upload_img` text NOT NULL,
  `call_back` text NOT NULL COMMENT '回复',
  `handler` varchar(20) NOT NULL COMMENT '处理人',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_user_dimond_log`
--

CREATE TABLE IF NOT EXISTS `t_user_dimond_log` (
  `id` int(11) NOT NULL,
  `uid` bigint(64) DEFAULT NULL,
  `use_time` bigint(20) DEFAULT NULL,
  `use_dimond` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 视图结构 `agency_to_ip_user`
--
DROP TABLE IF EXISTS `agency_to_ip_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`mahjong`@`localhost` SQL SECURITY DEFINER VIEW `agency_to_ip_user` AS select `a`.`id` AS `id`,`a`.`agency_id` AS `agency_id`,`a`.`action_time` AS `action_time`,`u`.`uid` AS `uid`,`u`.`username` AS `username`,`u`.`dimond` AS `dimond`,`u`.`sum_dimond` AS `sum_dimond`,`u`.`reg_ip` AS `reg_ip` from (`t_agency_and_user` `a` left join `t_game_user` `u` on((`a`.`agent_ip` = `u`.`reg_ip`))) where ((`u`.`uid` is not null) and (`u`.`username` is not null));

-- --------------------------------------------------------

--
-- 视图结构 `agency_to_wx_user`
--
DROP TABLE IF EXISTS `agency_to_wx_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`mahjong`@`localhost` SQL SECURITY DEFINER VIEW `agency_to_wx_user` AS select `a`.`id` AS `id`,`a`.`agency_id` AS `agency_id`,`a`.`unionid` AS `unionid`,`a`.`action_time` AS `action_time`,`u`.`uid` AS `uid`,`u`.`username` AS `username`,`u`.`register_time` AS `register_time`,`u`.`dimond` AS `dimond`,`u`.`sum_dimond` AS `sum_dimond` from (`t_agency_and_user` `a` left join `t_game_user` `u` on((`a`.`unionid` = `u`.`unionid`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_admin_group`
--
ALTER TABLE `t_admin_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `t_admin_log`
--
ALTER TABLE `t_admin_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id_idx` (`admin_id`);

--
-- Indexes for table `t_admin_user`
--
ALTER TABLE `t_admin_user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `t_agency`
--
ALTER TABLE `t_agency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `t_agency_and_user`
--
ALTER TABLE `t_agency_and_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unionid` (`unionid`);

--
-- Indexes for table `t_agency_bank_info`
--
ALTER TABLE `t_agency_bank_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_agency_diamond_change_log`
--
ALTER TABLE `t_agency_diamond_change_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_agency_get_dimond_back_log`
--
ALTER TABLE `t_agency_get_dimond_back_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_agency_sell_to_agency`
--
ALTER TABLE `t_agency_sell_to_agency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_ban_log`
--
ALTER TABLE `t_ban_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_data_count`
--
ALTER TABLE `t_data_count`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_time` (`data_time`);

--
-- Indexes for table `t_dimond_log`
--
ALTER TABLE `t_dimond_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_everyday_online_time_log`
--
ALTER TABLE `t_everyday_online_time_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_everyday_total_dimond_log`
--
ALTER TABLE `t_everyday_total_dimond_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_everyday_user_dimond_log`
--
ALTER TABLE `t_everyday_user_dimond_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_every_month_money_back`
--
ALTER TABLE `t_every_month_money_back`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_gamer_get_dimond_log`
--
ALTER TABLE `t_gamer_get_dimond_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_gamer_to_gamer`
--
ALTER TABLE `t_gamer_to_gamer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unionid` (`unionid`);

--
-- Indexes for table `t_game_room_log`
--
ALTER TABLE `t_game_room_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_game_user`
--
ALTER TABLE `t_game_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `openid` (`openid`),
  ADD UNIQUE KEY `unionid` (`unionid`);

--
-- Indexes for table `t_game_user_login_log`
--
ALTER TABLE `t_game_user_login_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_group`
--
ALTER TABLE `t_group`
  ADD PRIMARY KEY (`gid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `t_money_back_log`
--
ALTER TABLE `t_money_back_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_offlineplay_sign_sort`
--
ALTER TABLE `t_offlineplay_sign_sort`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_offline_play`
--
ALTER TABLE `t_offline_play`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_offline_play_setting`
--
ALTER TABLE `t_offline_play_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_online_count_log`
--
ALTER TABLE `t_online_count_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_online_log`
--
ALTER TABLE `t_online_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_recharge_log`
--
ALTER TABLE `t_recharge_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_status` (`order_status`);

--
-- Indexes for table `t_sell_log`
--
ALTER TABLE `t_sell_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_system_setting`
--
ALTER TABLE `t_system_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_test_log`
--
ALTER TABLE `t_test_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_charge_from_agency`
--
ALTER TABLE `t_user_charge_from_agency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_charge_order`
--
ALTER TABLE `t_user_charge_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_complain`
--
ALTER TABLE `t_user_complain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user_dimond_log`
--
ALTER TABLE `t_user_dimond_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_admin_group`
--
ALTER TABLE `t_admin_group`
  MODIFY `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_admin_log`
--
ALTER TABLE `t_admin_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_admin_user`
--
ALTER TABLE `t_admin_user`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_agency`
--
ALTER TABLE `t_agency`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_agency_and_user`
--
ALTER TABLE `t_agency_and_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_agency_bank_info`
--
ALTER TABLE `t_agency_bank_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_agency_diamond_change_log`
--
ALTER TABLE `t_agency_diamond_change_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_agency_get_dimond_back_log`
--
ALTER TABLE `t_agency_get_dimond_back_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_agency_sell_to_agency`
--
ALTER TABLE `t_agency_sell_to_agency`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_ban_log`
--
ALTER TABLE `t_ban_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_data_count`
--
ALTER TABLE `t_data_count`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_everyday_online_time_log`
--
ALTER TABLE `t_everyday_online_time_log`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_everyday_total_dimond_log`
--
ALTER TABLE `t_everyday_total_dimond_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_everyday_user_dimond_log`
--
ALTER TABLE `t_everyday_user_dimond_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_every_month_money_back`
--
ALTER TABLE `t_every_month_money_back`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_gamer_to_gamer`
--
ALTER TABLE `t_gamer_to_gamer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_game_room_log`
--
ALTER TABLE `t_game_room_log`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_game_user`
--
ALTER TABLE `t_game_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_game_user_login_log`
--
ALTER TABLE `t_game_user_login_log`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_group`
--
ALTER TABLE `t_group`
  MODIFY `gid` int(10) NOT NULL AUTO_INCREMENT COMMENT '群组id';
--
-- AUTO_INCREMENT for table `t_money_back_log`
--
ALTER TABLE `t_money_back_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_offlineplay_sign_sort`
--
ALTER TABLE `t_offlineplay_sign_sort`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_offline_play`
--
ALTER TABLE `t_offline_play`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_offline_play_setting`
--
ALTER TABLE `t_offline_play_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_online_count_log`
--
ALTER TABLE `t_online_count_log`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_online_log`
--
ALTER TABLE `t_online_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_recharge_log`
--
ALTER TABLE `t_recharge_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_sell_log`
--
ALTER TABLE `t_sell_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '代理等级';
--
-- AUTO_INCREMENT for table `t_system_setting`
--
ALTER TABLE `t_system_setting`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_test_log`
--
ALTER TABLE `t_test_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_charge_from_agency`
--
ALTER TABLE `t_user_charge_from_agency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_charge_order`
--
ALTER TABLE `t_user_charge_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_complain`
--
ALTER TABLE `t_user_complain`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_user_dimond_log`
--
ALTER TABLE `t_user_dimond_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
