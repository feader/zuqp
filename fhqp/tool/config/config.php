<?php

class config {

	private $appid;
	private $secret;

	function __construct(){
		$this->set_config_info();
	}

	private function set_config_info(){
		$this->set_values();
	}

	public function get_config_info(){
		$config = array();
		$config['appid'] = $this->appid;
		$config['secret'] = $this->secret;
		return $config;
	}

	public function http_curl($url){   
	  	$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
		$data = curl_exec($curl);
		curl_close($curl);
		//var_dump($data);
	  	return $data; // 返回数据  
	}  

	public function curl_post($url,$post_data){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // post数据
	    curl_setopt($ch, CURLOPT_POST, 1);
	    // post的变量
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $output = curl_exec($ch);
	    // var_dump($post_data);die;
	    curl_close($ch);
	    //打印获得的数据
	    return $output;
	    // print_r($output);
	}

	//获取玩家信息
	public function get_agency_info_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/get_user_info.php';
		      	break;   
		    case 2:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/get_user_info.php';
		      	break;  
		    case 3:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/get_user_info.php';
		      	break;    	   	
		    default:
		      	echo '参数错误！';die;
		      	break;
		}
		return $url;
	}	

	//游戏玩家自己充值生成订单的接口url
	public function make_charge_order_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/make_charge_order.php';
		      	break;   
		    case 2:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/make_charge_order.php';
		      	break;  
		    case 3:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/make_charge_order.php';
		      	break;    	   	
		    default:
		      	echo '参数错误！';die;
		      	break;
		}
		return $url;
	}	

	//玩家自己充值的微信订单回调url
	public function change_order_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/change_user_charge_order.php';
		      	break;   
		    case 2:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/change_user_charge_order.php';
		      	break;
		    case 3:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/change_user_charge_order.php';
		      	break;  	     	
		    default:
		      	echo '参数错误！';die;
		      	break;
		}
		return $url;
	}	

	//代理用户绑定登陆信息url
	public function agency_bind_check_url(){
		$data = array();
		$data[0] = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/agency_bind.php';
		$data[1] = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/agency_bind.php';	     	
		$data[2] = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/agency_bind.php';	     	
		return $data;
	}	

	//通过微信unionid直接登陆的url
	public function auth_login_url($game_id){
	  	switch ($game_id) {
	    	case 1:
	      		$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/module/agency/agency_login.php?action=auth_login';
	      		break;   
	      	case 2:
	      		$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/module/agency/agency_login.php?action=auth_login';
	      		break;
	      	case 3:
	      		$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/module/agency/agency_login.php?action=auth_login';
	      		break; 	   	
	    	default:
	      		echo '参数错误！';die;
	      		break;
	  	}
	  	return $url;
	}

	//绑定微信unionid直接登陆的url
	public function bind_login_url($game_id){
	  	switch ($game_id) {
	    	case 1:
	      		$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/agency_bind.php';
	      		break;   
	      	case 2:
	      		$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/agency_bind.php';
	      		break; 
	      	case 3:
	      		$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/agency_bind.php';
	      		break; 	  	
	    	default:
	      		echo '参数错误！';die;
	      		break;
	  	}
	  	return $url;
	}

	private function set_values(){
		
		$this->appid = 'wx216835025f67347a';
		$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	
	  	return $this;
	}

}

/**
 * Session控制类
 */
// class Session{
 
//   /**
//    * 设置session
//    * @param String $name  session name
//    * @param Mixed $data  session data
//    * @param Int  $expire 超时时间(秒)
//    */
//   public static function set($name, $data, $expire=600){
//     $session_data = array();
//     $session_data['data'] = $data;
//     $session_data['expire'] = time()+$expire;
//     $_SESSION[$name] = $session_data;
//   }
 
//   *
//    * 读取session
//    * @param String $name session name
//    * @return Mixed
   
//   public static function get($name){
//     if(isset($_SESSION[$name])){
//       if($_SESSION[$name]['expire']>time()){
//         return $_SESSION[$name]['data'];
//       }else{
//         self::clear($name);
//       }
//     }
//     return false;
//   }
 
//   /**
//    * 清除session
//    * @param String $name session name
//    */
//   private static function clear($name){
//     unset($_SESSION[$name]);
//   }
 
// }