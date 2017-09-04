<?php
$pay_config = array(
	0 => array(
			'total_fee'=>300,
			'dimond_cnt'=>300,
			'gift_dimond_cnt'=>0,
		),
	// 0 => array(
	// 		'total_fee'=>400,
	// 		'dimond_cnt'=>200,
	// 		'gift_dimond_cnt'=>0,
	// 	),
	// 1 => array(
	// 		'total_fee'=>600,
	// 		'dimond_cnt'=>400,
	// 		'gift_dimond_cnt'=>0,
	// 	),
	// 2 => array(
	// 		'total_fee'=>780,
	// 		'dimond_cnt'=>600,
	// 		'gift_dimond_cnt'=>0,
	// 	),
	// 3 => array(
	// 		'total_fee'=>960,
	// 		'dimond_cnt'=>800,
	// 		'gift_dimond_cnt'=>0,
	// 	),
	// 4 => array(
	// 		'total_fee'=>0.01,
	// 		'dimond_cnt'=>1,
	// 		'gift_dimond_cnt'=>0,
	// 	),
);

function get_value($product_id,$config){
	$data = array();
	$num = count($config);
	if($product_id>$num){
		$data['total_fee'] = 9999999;
		$data['dimond_cnt'] = 1;
		$data['gift_dimond_cnt'] = 0;
		return $data;
	}
	foreach ($config as $k => $v) {
		if($product_id-1 == $k){
			$data['total_fee'] = $v['total_fee'];
			$data['dimond_cnt'] = $v['dimond_cnt'];
			$data['gift_dimond_cnt'] = $v['gift_dimond_cnt'];
		}	
	}
	return $data;
}

