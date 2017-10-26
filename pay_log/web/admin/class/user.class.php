<?php


/*
 * Created on Oct 26, 2010
 *
 * 玩家信息类
 */
//注意php的诡异包含路径机制
 //include  dirname(__FILE__)."/../../config/config.php";      
        
class UserClass {
	
	public static function getUseridByUsername($erlangNode, $nickname) {
		$nickname = str_replace("\\'", "'", $nickname); // 还原 '
		$nickname = str_replace("\\\"", "\"", $nickname);  // 还原 "
		$nickname = str_replace("\\\\", "\\", $nickname);  // 还原 \
		$nickname = urlencode($nickname);
		
		$result = getJson ( $erlangNode."user?fun=getUseridByUsername&arg=$nickname" );
		return $result["roleid"];
	}

	public static function getUseridByAccountName($erlangNode,$accountName) {
		$accountName = str_replace("\\'", "'", $accountName); // 还原 '
		$accountName = str_replace("\\\"", "\"", $accountName);  // 还原 "
		$accountName = str_replace("\\\\", "\\", $accountName);  // 还原 \
		$accountName = urlencode($accountName);
				
		$result = getJson ( $erlangNode."user?fun=getUseridByAccountName&arg=$accountName" );
		return $result["roleid"];
	}
}
