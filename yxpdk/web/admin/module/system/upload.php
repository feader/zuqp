<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN.'/include/global2.php';
global $smarty, $db;

$data = array();

$data['file_name'] = $_FILES["img_list"]["name"]; 

if((($_FILES["img_list"]["type"] == "image/gif") || ($_FILES["img_list"]["type"] == "image/jpeg") || ($_FILES["img_list"]["type"] == "image/pjpeg") || ($_FILES["img_list"]["type"] == "image/png"))){
	  	
	if($_FILES["img_list"]["size"] > 2000000){

		$data['msg'] = '图片太大(大于2M)！';
		
		$data['code'] = 1;

		echo json_encode($data);die;
	
	}

  	if($_FILES["img_list"]["error"] > 0){
    	
    	$data['msg'] = '上传图片失败！';
		
		$data['code'] = 2;
    
    }else{

    	$file_name = $_FILES["img_list"]["name"];
	    $file_name = strrev($file_name);
	    $end_num = strpos($file_name,'.');
	    $type_name = substr($file_name,0,$end_num);
	    $type_name = strrev($type_name);

	    $rand = rand(1111,9999);

	    $upload_file_res = move_uploaded_file($_FILES["img_list"]["tmp_name"],'../../static/upload/complain/'.time().$rand.'.'.$type_name);

	    if($upload_file_res){

	  //   	$uploadfile = '../../static/upload/complain/'.time().$rand.'.'.$type_name;

			// $config = getimagesize($uploadfile);

			// $i = 0.5;

			// $image_p = imagecreatetruecolor($config[0]*$i,$config[1]*$i);
			
			// $image = imagecreatefromjpeg($uploadfile);
			
			// imagecopyresampled($image_p, $image, 0, 0, 0, 0, $config[0]*$i, $config[1]*$i, $config[0], $config[1]);
			// // 输出

			// $rand1 = rand(1111,9999);
			
			// imagejpeg($image_p,'../../static/upload/complain/'.time().$rand1.'.'.$type_name);

	    	$data['upload_img'] = '/static/upload/complain/'.time().$rand.'.'.$type_name;

	    	$data['msg'] = '上传图片成功！';
		
			$data['code'] = 3;

	    }else{

	    	$data['upload_img'] = 0;

	    	$data['msg'] = '移动图片失败！';
		
			$data['code'] = 4;

	    }
   		    
    }

}else{
  
 	$data['upload_img'] = 0;

 	$data['msg'] = '上传文件不是图片格式！';
		
	$data['code'] = 5;

}

echo json_encode($data);die;