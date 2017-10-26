<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN.'/include/global2.php';
global $smarty, $db;

$uid = $_GET['uid'];

if(!empty($_POST) && $_POST['action']=='save_complain'){

	if($_POST['uid']!=$_GET['uid']){

		$db->jump('非法操作！');
	
	}
	
	$table = 't_user_complain';

	$data = array();

	$data['uid'] = $_POST['uid'];
	
	$data['content'] = $_POST['content'];
	
	$data['create_time'] = time();

	if($_POST['upload_img']!='' && !empty($_POST['upload_img'])){

		$data['upload_img'] = $_POST['upload_img'];
	
	}else{

		$data['upload_img'] = 0;

	}

	// if((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg"))){
	  	
	// 	if($_FILES["file"]["size"] > 50000){

	// 		$db->jump('图片太大！');
		
	// 	}

	//   	if($_FILES["file"]["error"] > 0){
	    	
	//     	$db->jump('上传图片失败！');
	    
	//     }else{

	//     	$file_name = $_FILES["file"]["name"];
	// 	    $file_name = strrev($file_name);
	// 	    $end_num = strpos($file_name,'.');
	// 	    $type_name = substr($file_name,0,$end_num);
	// 	    $type_name = strrev($type_name);

	// 	    $upload_file_res = move_uploaded_file($_FILES["file"]["tmp_name"],"../../static/upload/complain/".$_POST['uid'].'_'.time().'.'.$type_name);

	// 	    if($upload_file_res){

	// 	    	$data['upload_img'] = '/static/upload/complain/'.$_POST['uid'].'_'.time().'.'.$type_name;

	// 	    }else{

	// 	    	$data['upload_img'] = 0;

	// 	    }
	   		
	// 	    // echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	// 	    // echo "Type: " . $_FILES["file"]["type"] . "<br />";
	// 	    // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	// 	    // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	// 	    //if(file_exists("upload/" . $_FILES["file"]["name"])){
		      
	// 	      	//echo $_FILES["file"]["name"] . " already exists. ";
		    
	// 	    //}else{
		      	
	// 	      	//$aaa = move_uploaded_file($_FILES["file"]["tmp_name"],"../static/upload/complain/" . $_FILES["file"]["name"]);
	// 	      	//var_dump($aaa);
	// 	      	//echo "Stored in: " . "../static/upload/complain/" . $_FILES["file"]["name"];
		    
	// 	    //}
	//     }
	
	// }else{
	  
	//  	$data['upload_img'] = 0;
	
	// }

	$res = $db->insert_data($data,$table);

	if($res){
		$db->jump('提交成功！','input_complain.php?uid='.$uid);
	}else{
		$db->jump('提交失败！','input_complain.php?uid='.$uid);
	}

}


$smarty->assign("uid",$uid);
$smarty->display('module/system/input_complain.html');