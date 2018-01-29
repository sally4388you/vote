<meta charset="UTF-8">
<?php
	include '../../excelreader/PHPExcel/IOFactory.php';
	include '../config.php';
	$type = (isset($_GET['type'])) ? $_GET['type'] : "voter";
	if (isset($_GET['filename'])){
		$filename = $_GET['filename'];
		$inputFileName = '../upfiles/'.$filename;
		if (is_readable($inputFileName)){
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$character = array('A','B','C','D','E');
			$error = 0;

			if ($type != "voter"){
				$title_default = array("studentid", "name", "department", "introduction", "time");
				for ($i = 0; $i < count($character); $i ++){//decide the name of every column
					switch ($sheetData[1][$character[$i]]) {
						case '学号' : $title[$i] = "studentid"; break;
						case '姓名' : $title[$i] = "name"; break;
						case '院系' : $title[$i] = "department"; break;
						case '简介' : $title[$i] = "introduction"; break;
						case '添加时间' : $title[$i] = "time"; break;
						case '身份证后6位' : $title[$i] = "identityid"; break;
						default : $title[$i] = $title_default[$i]; break;
					};
				}
			}
			else $title = array("studentid", "name", "identityid");

			if ($type != "voter"){
				$year = $_GET['year'];
				$project = $_GET['project'];
				$tablename = $project."_candidate_".$year;
				$votetablename = $project."_vote_".$year;
				$triggername = $project."_addone_".$year;
				$sql = "CREATE TABLE IF NOT EXISTS `{$votetablename}`(
							`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							`kid` INT(11) NOT NULL,
							`studentid` VARCHAR(11) NOT NULL,
							`time` datetime,
							`state` VARCHAR(10) DEFAULT '正常'
						)ENGINE=MyISAM DEFAULT CHARSET=utf8";
				mysqli_query($conn, $sql);
				$sql = "CREATE TABLE IF NOT EXISTS `{$tablename}`(
							`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							`studentid` VARCHAR(10) NOT NULL,
							`name` VARCHAR(50) NOT NULL,
							`department` VARCHAR(100),
							`introduction` TEXT,
							`time` datetime,
							`vote` INT(4) DEFAULT 0
						)ENGINE=MyISAM DEFAULT CHARSET=utf8";
				if (mysqli_query($conn, $sql)){
					$sql = "CREATE TRIGGER `{$triggername}`
								AFTER INSERT ON `{$votetablename}`
								FOR EACH ROW
									UPDATE `{$tablename}` SET `vote`=
										(SELECT COUNT(*) FROM `{$votetablename}` WHERE `kid`=new.kid)
										WHERE `id`=new.kid";
					mysqli_query($conn, $sql);
					for ($i = 2; $i <= count($sheetData); $i ++){
						$column_0 = $sheetData[$i]['A'];
						$column_1 = $sheetData[$i]['B'];
						$column_2 = $sheetData[$i]['C'];
						$column_3 = $sheetData[$i]['D'];
						$column_4 = $sheetData[$i]['E'];
						$sql = "INSERT INTO `{$tablename}`(`{$title[0]}`,`{$title[1]}`,`{$title[2]}`,`{$title[3]}`,`{$title[4]}`)
									VALUES('{$column_0}','{$column_1}','{$column_2}','{$column_3}','{$column_4}')";//echo $sql;
						if (!mysqli_query($conn, $sql)) $error += 1;
					}
				}
				else{
					$error += 1;
					echo "<script>alert('创建数据库失败');</script>";
				}
			}
			else{
				for ($i = 2; $i <= count($sheetData); $i ++){
					$column_0 = $sheetData[$i]['A'];//studentid
					$column_1 = $sheetData[$i]['B'];//name
					$column_2 = $sheetData[$i]['C'];//identityid

					if (strlen($column_2) == 5) {
						$column_2 = "0".$column_2;
					} else if (strlen($column_2) > 6) {
						$column_2 = substr($column_2, -6, 6);
					}

					if ($column_0 != "" && $column_1 != "" && $column_2 != "") {
						$year = substr($column_0, 1, 4);
						$tablename = "voter_".$year;
						$sql = "CREATE TABLE IF NOT EXISTS `{$tablename}`(
							`studentid` VARCHAR(20) NOT NULL PRIMARY KEY,
							`name` VARCHAR(50) NOT NULL,
							`identityid` VARCHAR(6)
						)ENGINE=MyISAM DEFAULT CHARSET=utf8";
						if (mysqli_query($conn, $sql)){
							$sql = "INSERT INTO `{$tablename}`(`{$title[0]}`,`{$title[1]}`,`{$title[2]}`)
						 				VALUES('{$column_0}','{$column_1}','{$column_2}')";
							if (!mysqli_query($conn, $sql)) $error += 1;
						}
						else{
							$error += 1;
							echo "<script>alert('创建数据库失败');</script>";
						}
					}
				}
			}

			if ($error == 0){
				$name = ($type == "voter") ? "voter" : $project;
				$sql = "INSERT INTO `setting`(`name`,`value`) VALUES('{$name}','{$year}')";
				mysqli_query($conn, $sql);
				$address = ($type == "voter") ? "type=setting" : "project={$project}&year={$year}";
	?>
				<html>
					<head>
						<meta http-equiv="content-type" content="text/html;charset=utf-8">
						<title></title>
						<script type="text/javascript">
							var t = 3;
							function countDown(){
								var time = document.getElementById("time");
								t --;
								time.innerHTML = t;
								if (t <= 0){
									location.href = "../back.php?<?php echo $address;?>";
									clearInterval(inter);
								}
							}
							var inter = setInterval("countDown()", 1000);
						</script>
					</head>
					<body onload="countDown()">
						<div style="text-align:center;margin:10% auto 0 auto;width:400px;">
							<img src="../../images/expression.jpg" style="float:left;">
							<div style="float:left;margin-top:40px;font-family:'微软雅黑';">
								<font size="6">导入成功</font><br />
								还有<span id="time">3</span>秒跳转页面
							</div>
						</div>
					</body>
				</html>
	<?php
			}
			else echo "<script>alert('导入失败');location.href='../back.php';</script>";
		}
		else echo "<script>alert('导入失败，请重试');location.href='../back.php';</script>";
	}
?>