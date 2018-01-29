<?php

	if (isset($_GET['add']))
	{
		$year = date("Y");
		$eng_name = $_POST['eng_name'];
		$ch_name = $_POST['ch_name'];
		$sql = "SELECT * FROM `projectname` WHERE `ch_name`='{$ch_name}' OR `eng_name`='{$eng_name}'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result)) echo "<script>alert('项目名称或项目缩写重名');history.go(-1);</script>";
		else{
			$sql = "INSERT INTO `setting`(`name`,`value`) VALUES('{$eng_name}','{$year}')";
			mysqli_query($conn, $sql);
			$sql = "INSERT INTO `projectname`(`ch_name`,`eng_name`) VALUES('{$ch_name}','{$eng_name}')";
			if (mysqli_query($conn, $sql)){
				echo "<script>location.href='?project={$eng_name}';</script>";
			}
			else echo "<script>alert('添加失败');history.go(-1);</script>";
		}
		die();
	}

	if (isset($_GET['addp']))
	{
		$year = $_GET['year'];
		$project = $_GET['project'];
		$time = date("Y-m-d H:i:s");
		$sql = "INSERT INTO `{$project}_candidate_{$year}`(`studentid`,`name`,`time`) VALUES('id','name','{$time}')";
		mysqli_query($conn, $sql);
		$id = mysqli_insert_id($conn);
		echo "<script>location.href='?project={$project}&year={$year}&id={$id}&revise=1';</script>";
		die();
	}

	if (isset($_GET['delete']))
	{
		$error = 0;
		$project = $_GET['project'];
		$year = $_GET['year'];
		$deleteid = $_POST['deleteid'];
		for ($i = 0; $i < count($deleteid); $i ++){
			$sql = "DELETE FROM `{$project}_candidate_{$year}` WHERE `id`='{$deleteid[$i]}'";
			if (!mysqli_query($conn, $sql)) $error += 1;
		}
		if ($error == 0) echo "<script>alert('删除成功');</script>";
		else echo "<script>alert('删除失败');</script>";
		echo "<script>location.href='?project={$project}&year={$year}';</script>";
		die();
	}

	if (isset($_GET['projectdelete']))
	{
		$error = 0;
		$year = $_POST['year'];
		$projectname = $_POST['projectname'];
		if ($year == "所有年份"){
			$sql = "DELETE FROM `setting` WHERE `name`='{$projectname}'";if (!mysqli_query($conn, $sql)) $error += 1;
			$sql = "DELETE FROM `projectname` WHERE `eng_name`='{$projectname}'";if (!mysqli_query($conn, $sql)) $error += 1;
		}
		else{
			$sql = "DELETE FROM `setting` WHERE `name`='{$projectname}' AND `value`='{$year}'";if (!mysqli_query($conn, $sql)) $error += 1;
			$sql = "SELECT * FROM `setting` WHERE `name`='{$projectname}'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result, MYSQLI_BOTH);
			if (count($row) == 0){
				$sql = "DELETE FROM `projectname` WHERE `eng_name`='{$projectname}'";if (!mysqli_query($conn, $sql)) $error += 1;
			}
		}
		if ($error == 0) echo "<script>alert('删除成功');</script>";
		else echo "<script>alert('删除失败');</script>";
		echo "<script>location.href='?type=setting';</script>";
		die();
	}

	if (isset($_GET['search']))
	{
		$search = $_GET['search'];
		$sql = "SELECT DISTINCT `{$search}` FROM `activity`";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
		{
			if ($row[$search] != '')
				echo "<option value='{$row[$search]}'>{$row[$search]}</option>";
		}
		die();
	}
?>