<?php
if (!defined('MING2_WEB_ADMIN_FLAG')) {
	exit ('hack attemp');
}
include SYSDIR_ROOT_CLIENT.'config/config.item.php';
global $itemNameConfig;

function get_item_name($id){
	global $itemNameConfig;
	return $itemNameConfig[$id]['name'];
}