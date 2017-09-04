<?php

class ToolClass{

	/*
	 * $execel_data 要execel导出的数据，二维数组		
	 *
	*/	

	public function down_execel($execel_data,$title_data){

		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
	 	
	 	$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 		->setLastModifiedBy("Maarten Balliauw")
								 		->setTitle("Office 2007 XLSX Test Document")
								 		->setSubject("Office 2007 XLSX Test Document")
								 		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 		->setKeywords("office 2007 openxml php")
								 		->setCategory("Test result file");
		
		
		
		foreach ($title_data as $k => $v) {	
								
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($k, $v);//分号很重要，没加会出错
												
		}

		$cellNum = count($title_data);
        $dataNum = count($execel_data);

		for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $execel_data[$i][$title_data[$j][0]]);
          }             
        }  

        var_dump($objPHPExcel);die;

        $objPHPExcel->getActiveSheet()->setTitle('sheet1');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$time_name =  '回复数据'.date('YmdHis',time()).'.xls';

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename='$time_name'");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		die;

		

		

	 	
	}




































}