<?php
	session_start();
	include_once './backEnd/config.php';
	include_once "./backEnd/language.php";
	if (isset($_POST['studentid'])){
		// if (isset($_SESSION['votetimes']) && $_SESSION['votetimes'] < 3 || !isset($_SESSION['votetimes'])){
			$studentid = ($_POST['studentid'] == "")? "a" : $_POST['studentid'];
			$password = ($_POST['password'] == "")? "a" : $_POST['password'];
			$name = $_POST['name'];
			if (strlen($studentid) == 10){
				$year = substr($studentid, 1,4);
				$sql = "SELECT * FROM `voter_{$year}` WHERE `studentid`='{$studentid}'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
				if ($password == $row['identityid'] && $name == substr($row['name'], 0, 3)){
					$_SESSION['studentid'] = $studentid;
					$_SESSION['studentname'] = $row['name'];
					echo "<script>location.href='index.php';</script>";
					die();
				}
				else{
					// if (isset($_SESSION['votetimes'])) $_SESSION['votetimes'] += 1;
					// else $_SESSION['votetimes'] = 1;
					echo "<script>alert('输入信息有误');</script>";
				}
			}
			else echo "<script>alert('学号输入有误');</script>";
		// }
		// else echo "<script>alert('输入信息错误超过3次');</script>";
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $app[$lang]['title'] ?></title>
	<link rel="stylesheet" type="text/css" href="./css/main.css">
	<script src="js/main.js"></script>
</head>
<body class="load-bd">
	<h1><?= $app[$lang]['voteSystem'] ?></h1>
	<div class="load">
		<form action="" method="post" onsubmit="return checkLoginForm(this);">
			<input type="text" value="<?php echo (isset($_POST['studentid'])) ? $_POST['studentid'] : $app[$lang]['account'];?>" name="studentid"/><br />
			<input type="text" value="<?php echo (isset($_POST['studentid'])) ? $_POST['password'] : $app[$lang]['id'];?>" name="password"/><br />
			<input type="text" value="<?php echo (isset($_POST['studentid'])) ? $_POST['name'] : $app[$lang]['name'];?>" name="name"><br />
			<input type="submit" value="<?= $app[$lang]['login'] ?>"><br />

			<p style="text-align:center; margin-top:10px;"><?= $app[$lang]['loginMessage'] ?></p>

			<div class="load-regist">
				<!-- <p>每人最多可以投十票</p> -->
				<p style="margin-top:100px;">&copy;<?= $app[$lang]['copy'] ?> </p>
			</div>
		</form>
	</div>
	<script>
		var aInt = document.getElementsByTagName('input');
		aInt[0].onblur = function () {
			if (this.value == "") this.value = "<?= $app[$lang]['account'] ?>";
			this.style.color = "#999";
		}
		aInt[0].onfocus = function(){
			this.value = "";
			this.style.color = "#333";
		}
		aInt[1].onblur = function () {
			if (this.value == ""){
				this.type = "text";
				this.value = "<?= $app[$lang]['id'] ?>";
			}
			this.style.color = "#999";
		}
		aInt[1].onfocus = function(){
			this.type = "password";
			this.value = "";
			this.style.color = "#333";
		}
		aInt[2].onblur = function () {
			if (this.value == "") this.value = "<?= $app[$lang]['name'] ?>";
			this.style.color = "#999";
		}
		aInt[2].onfocus = function(){
			this.value = "";
			this.style.color = "#333";
		}
	</script>
</body>
</html>