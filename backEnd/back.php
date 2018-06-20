<?php

	session_start();
	include_once 'config.php';
	include_once 'language.php';

	if(!isset($_SESSION['managerID'])){
	    echo "<script>location.href='login.php';</script>";
	    die();
	}
	else $managerID = $_SESSION['managerID'];

	$project = isset($_GET['project']) ? strip_tags($_GET ['project']) : "sfu";
	if (isset($_GET['type'])) $type = $_GET['type'];
	if (isset($_GET['isshowed']))
	{
		$id = $_GET['isshowid'];
		$isshowed = ($_GET['isshowed'] == 1) ? 0 : 1;
		$sql = "UPDATE `projectname` SET `isshowed`='{$isshowed}' WHERE `id`='{$id}'";
		mysqli_query($conn, $sql);
		echo $isshowed;
		if ($isshowed){
			$sql = "SELECT * FROM `projectname` WHERE `id`!='{$id}'";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
				$_sql = "UPDATE `projectname` SET `isshowed`='0' WHERE `id`='{$row['id']}'";
				mysqli_query($conn, $_sql);
			}
		}
		die();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="../css/back.css" rel="stylesheet" type="text/css">
	<title><?= $app[$lang]['titleManage'] ?></title>
	<script src="../js/back.js"></script>
</head>
<body>
	<?php include_once 'addthings.php';?>
	<div class="top">
		<img src="../images/ehust.png" class="logo">
		<div class="title">
			<font color="#0070aa" size="5">学工处·投票系统</font><br />
			<font  size="2" style="letter-spacing:-1;">Voting system of Student Affairs Office</font>
		</div>
		<div class="logout">
			<img src="../images/logout.png" align="center" /><a href="logout.php"><?= $app[$lang]['logout'] ?></a>
			<img src="../images/about.png" align="center" /><a href="javascript:void(0)" onclick="alert('如有任何使用问题或页面错误问题，请加qq327464680，我们会及时解决');" style="line-height:21px;"><?= $app[$lang]['feedback'] ?></a>
		</div>
	</div>
	<div class="guide_line"><?= $app[$lang]['welcome'] ?> <?php echo $managerID;?>!</div>

	<div id="left_menu">
		<ul class="left_ul">
<?php
			$sql = "SELECT * FROM `projectname`";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
?>
			<li id="<?php echo $row['eng_name'];?>" class="left_ul_title not-choosed">
				<a href="#">
					<span class="menu_ico"><img src="../images/info.gif" /></span>
					<span><?php echo $row[$lang == 'en' ? 'eng' : 'ch_name'];?></span><span class="menu_arr"></span>
				</a>
				<ul>
<?php
				$_sql = "SELECT DISTINCT `value` FROM `setting` WHERE `name`='{$row['eng_name']}' ORDER BY `value` ASC";
				$_result = mysqli_query($conn, $_sql);
				while ($_row = mysqli_fetch_array($_result, MYSQLI_BOTH)){
?>
	                <li id="<?php echo $row['eng_name'].$_row['value'];?>"><a href="?project=<?php echo $row['eng_name'];?>&year=<?php echo $_row['value'];?>"><span class="left_arr"><img src="../images/list_arr.gif" /></span><span><?php echo $_row['value'];?><?= $app[$lang]['year'] ?></span></a></li>
<?php
				}
?>
	            </ul>
            </li>
<?php
			}
?>
			
			<li id="setting"><a href="?type=setting"><span class="menu_ico"><img src="../images/info.gif" /></span><span><?= $app[$lang]['setting'] ?></span></a></li>

			<li><a href="logout.php"><span class="menu_ico"><img src="../images/logout.gif" /></span><span><?= $app[$lang]['logout'] ?></span></a></li>

			<li><a href="javascript:void(0)" onclick="add();"><span class="menu_ico"><img src="../images/add.gif" /></span><span><?= $app[$lang]['add_prog'] ?></span></a></li>
		</ul>
		<!-- <span class="add"><a href="javascript:void(0)"><img src="../images/add.png" align="center" onclick="add();"></a><?= $app[$lang]['add_prog'] ?></span> -->
		<form action="?add=1" method="post" id="addForm" onsubmit="return checkaddForm(this);">
			<?= $app[$lang]['prog_name'] ?>:<br />&nbsp;&nbsp;
				<input name="ch_name" type="text" /><br />
			<?= $app[$lang]['prog_eng'] ?>:<br />&nbsp;&nbsp;
				<input name="eng_name" type="text" /><br /><br />
			<input type="submit" value="<?= $app[$lang]['add_btn'] ?>" class="addbutton" />
			<input type="button" value="<?= $app[$lang]['cancel_btn'] ?>" class="addbutton" onclick="addFormClear();" />
		</form>
	</div>
	<div id="basicInfo">
<?php
		$year = isset($_GET['year']) ? strip_tags($_GET ['year']) : date("Y");
		if ($project != ""){
			echo "<script>document.getElementById('{$project}').className='left_ul_title left_on choosed';
						  document.getElementById('{$project}{$year}').className='left_on';</script>";
		}
		else echo "<script>document.getElementById('{$type}').className='left_on';</script>";

		if (!isset($_GET['type'])){
			$page = isset($_GET['page']) ? strip_tags($_GET ['page']) : 1;
			$count = ($page - 1) * 20;
			$sql = "SELECT * FROM `{$project}_candidate_{$year}`";
			$result = mysqli_query($conn, $sql);
			$total = (int)(mysqli_num_rows($result) / 20);
			(mysqli_num_rows($result) % 20 == 0) ? '' : $total += 1;
		}

		$url = (isset($_GET['type'])) ? $_GET['type'].".php" : "candidate.php";
		include_once $url;
		$id = isset($_GET['id']) ? strip_tags($_GET ['id']) : '0';
		if ($id != '0'){
			detail($id, $year, $project);
		} else{
			include_once 'samethings.php';
			if (!isset($_GET['type'])) show($year, $project);
			else show();
		} if (!isset($type)) {
			// turnpage_show($project, $year);
		}
?>
	</div>
	<script type="text/javascript">
		list_up_down();
	</script>
</body>
</html>