<?php 
if (!defined('IN_DATANG_SYSTEM')) {
	exit('hack attemp!');
}

//定义项目根目录
define('SYSDIR_ROOT_CLIENT', realpath(dirname(__FILE__)."/../../") . DIRECTORY_SEPARATOR);
define('SYSDIR_ROOT', realpath(dirname(__FILE__)."/../") . DIRECTORY_SEPARATOR);
define('MING2_WEB_ADMIN_FLAG', true);

define('SYSDIR_CLASS', SYSDIR_ROOT."class");
define('SYSDIR_INCLUDE', SYSDIR_ROOT."include");
define('SYSDIR_LIBRARY', SYSDIR_ROOT."library");
define('SYSDIR_CONFIG', SYSDIR_ROOT.'config');

define('SYSDIR_ADMIN', SYSDIR_ROOT.'admin');

//包含配置文件
include SYSDIR_ROOT_CLIENT.'config/config.inc.php';
include SYSDIR_ROOT_CLIENT.'config/config.server.php';

// $erlangWebAdminHost = "http://192.168.1.64:".WEB_PORT;

