<meta charset="UTF-8">
<?php
	include_once "../config.php";
	if (isset($_POST['studentid'])){
		$project = $_GET['project'];
		$year = $_GET['year'];
		$id = $_GET['id'];
		$studentid = $_POST['studentid'];
		$name = $_POST['name'];
		$department = $_POST['department'];
		$introduction = $_POST['introduction'];
		$sql = "UPDATE `{$project}_candidate_{$year}`
				SET `studentid`='{$studentid}',
					`name`='{$name}',
					`department`='{$department}',
					`introduction`='{$introduction}'
				WHERE `id`='{$id}'";
		if (mysqli_query($conn, $sql)) echo "<script>alert('修改成功');location.href='../back.php?project={$project}&year={$year}';</script>";
		else echo "<script>alert('修改失败');history.go(-1);</script>";
	}

?>