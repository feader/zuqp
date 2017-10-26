<?php
define('IN_DATANG_SYSTEM', true);
include "../../../config/config.php";
include SYSDIR_ADMIN."/include/global.php";
global $smarty, $db;

$post_url = 'https://pay2.badambiz.com/api/order/query_order/';

$data = array();
$input_data = array();

if(!empty($_POST)){

	$data['ids'] = $_POST['id'];
	$data['appid'] = 'e60342626030dc3682835e7d6bc69f72';
	$data['type'] = $_POST['type'];
	$res = curl_post($post_url,$data);

	$input_data['id'] = $_POST['id'];
	$input_data['type'] = $_POST['type'];

	$data_date = json_decode($res,true);

	//$list_len = $data_date['data']['len'];

	//$list_len = 1;

	$list = $data_date['data']['list'];
	//var_dump($input_data);
	// var_dump($res);
	// var_dump($data_date);
	// var_dump($_POST);
}


function curl_post($url,$post_data){

    $postData = http_build_query($post_data);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT,'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	$output = curl_exec($curl); 
	curl_close($curl);
    //打印获得的数据
    return $output;
    //print_r($output);
}



$smarty->assign("data_date", $data_date);
$smarty->assign("input_data", $input_data);
$smarty->assign("list", $list);
// $smarty->assign("list_len", $list_len);
$smarty->display("module/game_data/data_count_list.html");