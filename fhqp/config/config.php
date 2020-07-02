<?php

class config {

	private $appid;
	private $secret;

	function __construct($game_id){
		$this->set_config_info($game_id);
	}

	private function set_config_info($game_id){
		$this->set_values($game_id);
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

	//通过代理分享新增的玩家数据抓取
	public function get_game_server_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/get_post_api.php';
		      	break;   
		    case 2:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/get_post_api.php';
		      	break;  
		    case 3:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/get_post_api.php';
		      	break;    
		    case 4:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhnz/web/admin/api/get_post_api.php';
		      	break;    
		    case 5:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/hzgd/web/admin/api/get_post_api.php';
		      	break;   
		    case 7:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/ydnn/web/admin/api/get_post_api.php';
		      	break;     	   	  		   	
		    default:
		      	echo '参数错误！';die;
		      	break;
		}
		return $url;
	}	

	//游戏玩家推广新增的用户
	public function get_gamer_to_gamer_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/get_gamer_post_api.php';
		      	break;   
		    case 2:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/get_gamer_post_api.php';
		      	break; 
		    case 3:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/get_gamer_post_api.php';
		      	break;  
		    case 4:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhnz/web/admin/api/get_gamer_post_api.php';
		      	break;  
		    case 5:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/hzgd/web/admin/api/get_gamer_post_api.php';
		      	break;   
		    case 7:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/ydnn/web/admin/api/get_gamer_post_api.php';
		      	break;     	 	  	 	    	
		    default:
		      	echo '参数错误！';die;
		      	break;
		}
		return $url;
	}	

	//活动签到获取数据url
	public function get_game_activity_sign_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/scmj/web/admin/api/get_game_activity_sign_post_api.php';
		      	break;   
		    case 2:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/yxpdk/web/admin/api/get_game_activity_sign_post_api.php';
		      	break; 
		    case 3:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhgd/web/admin/api/get_game_activity_sign_post_api.php';
		      	break;  
		    case 4:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/fhnz/web/admin/api/get_game_activity_sign_post_api.php';
		      	break;
		    case 5:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/hzgd/web/admin/api/get_game_activity_sign_post_api.php';
		      	break; 
		    case 7:
		      	$url = 'http://houtai.hainanjiuyue.com/houtai/ydnn/web/admin/api/get_game_activity_sign_post_api.php';
		      	break;   	 	  	 	    	
		    default:
		      	echo '参数错误！';die;
		      	break;
		}
		return $url;
	}	

	public function jump_url($game_id){
	  	switch ($game_id) {
	    	case 1:
	      		$url = 'http://houtai.hainanjiuyue.com/';
	      		break;   
	      	case 2:
	      		$url = 'http://pdk.yzbmsh.cn/?s=client';
	      		break; 
	      	case 3:
	      		$url = 'http://gd.yzbmsh.cn/?s=client';
	      		break; 	  	
	      	case 4:
	      		$url = 'http://fhnz.yzbmsh.cn/?s=client';
	      		break; 	  	
	      	case 5:
	      		$url = 'http://gdbz.yzbmsh.cn/?s=client';
	      		break; 	
	      	case 7:
	      		$url = 'http://ydnn.yzbmsh.cn/?s=client';
	      		break; 		  			
	    	default:
	      		echo '参数错误！';die;
	      		break;
	  	}
	  	return $url;
	}

	private function set_values($game_id){
		switch ($game_id) {
	    	case 1:
	      		$this->appid = 'wx216835025f67347a';
				$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	      		break;   
	      	case 2:
	      		$this->appid = 'wx216835025f67347a';
				$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	      		break;
	      	case 3:
	      		$this->appid = 'wx216835025f67347a';
				$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	      		break;	 
	      	case 4:
	      		$this->appid = 'wx216835025f67347a';
				$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	      		break;	 
	      	case 5:
	      		$this->appid = 'wx216835025f67347a';
				$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	      		break;	
	      	case 7:
	      		$this->appid = 'wx216835025f67347a';
				$this->secret = '3fd55566e5e6753cfb3ca66a88c755a6';
	      		break;	 	 				  
	    	default:
	      		echo '参数错误！';die;
	      		break;
	  	}
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