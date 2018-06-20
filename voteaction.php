<?php

	include_once "./backEnd/language.php";
	if (isset($_POST['wondnte'])){
		$sql = "SELECT * FROM `setting` WHERE `name`='opentime'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_BOTH);
		$opentime = $row['value'];
		$sql = "SELECT * FROM `setting` WHERE `name`='closetime'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_BOTH);
		$closetime = $row['value'];
		$time = date("Y-m-d");
		if ($time >= $opentime && $time <= $closetime){
			if (!isset($_SESSION['studentid'])){
				echo "<script>alert('请先登录');location.href='login.php';</script>";
				die();
			}
			$studentid = $_SESSION['studentid'];
			$project = $_SESSION['project'];
			$year = $_SESSION['year'];
			// if (isset($_COOKIE['isvote']) && $_COOKIE['isvote'] == 'isvote'){
			// 	echo "<script>alert('已投过票');location.href='index.php';</script>";
			// 	die();
			// }
			if (isset($_POST['wondnte'])){
				$sql = "SELECT * FROM `setting` WHERE `name`='votetime'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
				$votetime_set = intval($row['value']);

				$sql = "SELECT * FROM `{$project}_vote_{$year}` WHERE `studentid`='{$studentid}'";
				$result = mysqli_query($conn, $sql);
				$votetime = mysqli_num_rows($result);
				if ($votetime >= $votetime_set){
					// setcookie('isvote','isvote');
					echo "<script>alert('投票次数已超过{$votetime_set}次');</script>";
				}
				else {
					$encryptionid = $_POST['wondnte'];
					$count = substr($encryptionid, 3, 1);
					$kid = substr($encryptionid, 4, $count);
					$kid = intval($kid);

					$sql = "SELECT * FROM `{$project}_vote_{$year}` WHERE `studentid`='{$studentid}' AND `kid`='{$kid}'";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0){
						echo "<script>alert('不能重复投票给同一人');location.href='index.php';</script>";
					}
					else{
						$votetime = $votetime_set - $votetime - 1;
						$time = date('Y-m-d H:i:s');
						$sql = "INSERT INTO `{$project}_vote_{$year}`(`kid`,`studentid`,`time`)
									VALUES('{$kid}','{$studentid}','{$time}')";
						if (mysqli_query($conn, $sql)){
							// setcookie('isvote','isvote', time() + 3600 * 24 * 5);
							echo "<script>document.getElementById('votetime').innerHTML='{$votetime}';document.getElementById('cover').style.display='inline';</script>";
						}
						else echo "<script>alert('". $app[$lang]['voteFail'] ."');</script>";
					}
				}
			}
			else{
				echo "<script>alert('". $app[$lang]['voteFail'] ."');</script>";
			}
		}
		else if ($time > $closetime){
			echo "<script>alert('". $app[$lang]['voteEnd'] ."');</script>";
		}
		else if ($time < $opentime){
			echo "<script>alert('". $app[$lang]['voteNotBegin'] ."');</script>";
		}
	}
?>