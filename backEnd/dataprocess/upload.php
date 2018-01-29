<meta charset="UTF-8">
<?php

	$type = (isset($_GET['type'])) ? $_GET['type'] : "candidate";
	$year = (isset($_POST['year'])) ? $_POST['year'] : "";
	$project = isset($_POST['project']) ? $_POST['project'] : "";

	if ($type == "picture"){
		$error = 0; $suc = 0;
		$upfile = $_FILES["picture"];
		$count = count($upfile['name']);
		for ($i = 0; $i < $count; $i ++){
			$name = $upfile["name"][$i];
			$tmp_name = $upfile["tmp_name"][$i];
			$filetype = $upfile["type"][$i];
			if ($filetype == "image/jpeg" ||  $filetype == "image/pjpeg"){
				if(is_uploaded_file($_FILES['picture']['tmp_name'][$i])){
					$filepath = $_SERVER['DOCUMENT_ROOT'].'/photos/'.$project.'_'.$year;
					if (!file_exists($filepath)) mkdir($filepath);
					if (is_readable($filepath."/".strtolower($name))){
						@unlink($filepath."/".strtolower($name));
						//echo "<script>alert('1');</script>";
					}
					
					move_uploaded_file($tmp_name, $filepath."/".strtolower($name));
					$error += intval($upfile["error"][$i]);
					switch ($upfile["error"][$i]){
						case 0 : $errorinfo = "";break;
						case 1 : $errorinfo = "超过了文件大小，在php.ini文件中设置";break;
						case 2 : $errorinfo = "超过了文件的大小MAX_FILE_SIZE选项指定的值";break;
						case 3 : $errorinfo = "文件只有部分被上传";break;
						case 4 : $errorinfo = "没有文件被上传";break;
						default : $errorinfo = "上传文件大小为0";break;
					}
					if ($errorinfo != "") echo "<script>alert('图片{$name}{$errorinfo}');</script>";
					else $suc += 1;
				}
			}
			else{
				echo "<script>alert('图片{$name}不为jpg格式');</script>";
			}
		}
		if (isset($error) && $error == 0) echo "<script>alert('{$suc}张图片上传成功');location.href='../back.php?project={$project}&year={$year}';</script>";
		else echo "<script>alert('上传失败');history.go(-1);</script>";
	}

	else{
		$upfile = $_FILES["info"];
		$name = $upfile["name"];
		$tmp_name = $upfile["tmp_name"];
		$filetype = $upfile["type"];
		$filepath = $_SERVER['DOCUMENT_ROOT'].'/backEnd/upfiles/';//echo $filepath;dirname(__DIR__);
		// $filepath = dirname(dirname(__DIR__)).'\backEnd\upfiles\\';

		$okType = ($filetype == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') ? true : false;
		if ($okType){
			if (is_readable($filepath.$name)) @unlink ($filepath.$name);
			if(is_uploaded_file($_FILES['info']['tmp_name'])){
				move_uploaded_file($tmp_name, $filepath.$name);
				$error = $upfile["error"];
			}
		}
		else{
			echo "<script>alert('请上传xlsx的表格文件');history.go(-1);</script>";
			die();
		}
		if (isset($error) && $error == 0)
			if (is_readable($filepath.$name))
				echo "<script>alert('上传成功,正在导入数据库,请稍后');location.href='intoDB.php?type={$type}&filename={$name}&project={$project}&year={$year}';</script>";
		else echo "<script>alert('上传失败');history.go(-1);</script>";
	}
?> 