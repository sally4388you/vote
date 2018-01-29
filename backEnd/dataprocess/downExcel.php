<?php
	date_default_timezone_set ('Asia/Shanghai');
	$filename = "model.xlsx";
	$file_size = filesize($filename);
	$file = fopen($filename, "r");
	$savename = "model".date("YmdHis").".xlsx";

	Header("Content-type:application/octet-stream; charset=gb2312");
	Header("Accept-Ranges:bytes");
	header("Content-Type: application/msexcel");
	Header("Accept-Length:".$file_size);
	Header("Content-Disposition:attachment;filename=".$savename);
	$buffer_size = 1024;
	$cur_pos = 0;
	while(!feof($file) && $file_size - $cur_pos > $buffer_size){
		$buffer = fread($file, $buffer_size);
		echo $buffer;
		$cur_pos += $buffer_size;
	}
	echo fread($file, $file_size - $cur_pos);
	fclose($file);
?>