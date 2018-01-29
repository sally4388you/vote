<?php
	include_once "../config.php";
	$project = $_GET['project'];
	$year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
	header("content-type:text/html;charset=utf-8");
	/** Error reporting */
	error_reporting(E_ALL);
	/** PHPExcel */
	include_once '../../excelreader/PHPExcel.php';
	 
	/** PHPExcel_Writer_Excel2003用于创建xls文件 */
	include_once '../../excelreader/PHPExcel/Writer/Excel5.php';
	 
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	 
	// Set properties
	$objPHPExcel->getProperties()->setCreator("NADC");
	$objPHPExcel->getProperties()->setLastModifiedBy("NADC");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
	 
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', '学号');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', '姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', '学院');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', '简介');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', '添加时间');
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', '票数');
	//合并单元格：
	$i = 1;
	$sql = "SELECT * FROM `{$project}_candidate_{$year}`";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
		$i += 1;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, $row['studentid']);
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $row['name']);
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $row['department']);
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $row['introduction']);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $row['time']);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $row['vote']);
	}
	 
	// Rename sheet
	$filename = $project."_".$year.date("His");
	$objPHPExcel->getActiveSheet()->setTitle($filename);
	 
	   
	// Save Excel 2007 file
	//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	  
	 $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	 // $objWriter->save(str_replace('.php', '.xls', __FILE__));
	 header("Pragma: public");
	 header("Expires: 0");
	 header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
	 header("Content-Type:application/force-download");
	 header("Content-Type:application/vnd.ms-execl");
	 header("Content-Type:application/octet-stream");
	 header("Content-Type:application/download");
	 header("Content-Disposition:attachment;filename={$filename}.xls");
	 header("Content-Transfer-Encoding:binary");
	 $objWriter->save("php://output");
?>