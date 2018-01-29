<?php
	
	function head(){
		GLOBAL $conn;
?>
		<div class="top">
		<div class="main">
			<p class="head">
<?php
			$sql = "SELECT * FROM `setting` WHERE `name`='firstTitle'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result, MYSQLI_BOTH);
			echo $row['value'];
?>
			</p>
			<p class="welcome">
<?php
			if (isset($_SESSION['studentname'])){
?>
				欢迎登录 <?php echo $_SESSION['studentname'];?>! <a href="logout.php">退出登陆</a>
<?php 
			}
			else{
?>
				<a href="login.php">登录</a>
<?php
			}
?>
			</p>
		</div>
	</div>
<?php
	}

	function tail(){
		GLOBAL $conn, $project;
		$backyear = intval(date("Y") - 1);
		$sql = "SELECT * FROM `setting` WHERE `name`='{$project}' AND `value`='{$backyear}'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) $back = 1; else $back = 0;

		$sql = "SELECT * FROM `setting_long` WHERE `name`='tail'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_BOTH);
?>
		<div class="vote-per bottom">
			<a href="<?php echo ($back) ? 'index.php?backyear=1' : 'javascript:void(0)';?>" class="<?php echo ($back) ? 'backyear' : 'noback';?>">
				【查看上期投票情况】
			</a>
			<div style="text-align:left;padding-left:10px;"><?php echo $row['value'];?></div>
		</div>
<?php
	}
?>