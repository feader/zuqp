<?php

class config {
	
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

	//游戏下载页
	public function down_game_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = 'http://houtai.hainanjiuyue.com/?s=client';
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
		      	$url = '';
		      	break;
		}
		return $url;
	}	

	//图标
	public function icon_img_url($game_id){
		switch ($game_id) {
		    case 1:
		      	$url = '../static/img/tip.png';
		      	break;   
		    case 2:
		      	$url = '../static/img/pdk.png';
		      	break;  
		    case 3:
		      	$url = '../static/img/gd.png';
		      	break;  
		    case 4:
		      	$url = '../static/img/fhnz.png';
		      	break;  
		    case 5:
		      	$url = '../static/img/hzgd.png';
		      	break;  
		    case 7:
		      	$url = '../static/img/ydnn.png';
		      	break;   	  	  	  	   	
		    default:
		      	$url = '';
		      	break;
		}
		return $url;
	}	

	public function android_location_url($game_id,$rid){
		switch ($game_id) {
		    case 1:
		      	$url = 'gdapp://fhgd.app/openwith?roomId=';
		      	break;   
		    case 2:
		      	$url = 'fhpdkapp://fhpdk.app/openwith?roomId=';
		      	break;  
		    case 3:
		      	$url = 'gdapp://fhgd.app/openwith?roomId=';
		      	break; 
		    case 4:
		      	$url = 'fhnzapp://fhnz.app/openwith?roomId=';
		      	break;  
		    case 5:
		      	$url = 'hzgdapp://hzgd.app/openwith?roomId=';
		      	break;  
		    case 7:
		      	$url = 'ydnnapp://ydnn.app/openwith?roomId=';
		      	break;    	  	  	   	   	
		    default:
		      	$url = '';
		      	break;
		}
		return $url.$rid;
	}	

	public function ios_location_url($game_id,$rid){
		switch ($game_id) {
		    case 1:
		      	$url = 'gdapp://';
		      	break;   
		    case 2:
		      	$url = 'pdkapp://';
		      	break;  
		    case 3:
		      	$url = 'gdapp://';
		      	break;    	
		    case 4:
		      	$url = 'zjnzAPP://';
		      	break;    	
		    case 5:
		      	$url = 'hzgdApp://';
		      	break;    	  
		    case 7:
		      	$url = 'YDNNApp://';
		      	break;  		  	   	
		    default:
		      	$url = '';
		      	break;
		}
		return $url.$rid;
	}	

	
}



















