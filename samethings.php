<?php
	
	include_once "backEnd/language.php";

	function head(){
		GLOBAL $conn;
		GLOBAL $app;
		GLOBAL $lang;
?>
		<div class="top">
		<div class="main">
			<p class="head">
<?php
			$sql = "SELECT * FROM `setting` WHERE `name`='firstTitle'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result, MYSQLI_BOTH);
			echo $row[$lang == 'en' ? 'eng' : 'value'];
?>
			</p>
			<p class="welcome">
<?php
			if (isset($_SESSION['studentname'])){
?>
				<?= $app[$lang]['welcome'] ?> <?php echo $_SESSION['studentname'];?>! <a href="logout.php"><?= $app[$lang]['logout'] ?></a>
<?php 
			}
			else{
?>
				<a href="login.php"><?= $app[$lang]['login'] ?></a> |
				<a href="?lang=<?= $lang == 'en' ? 'zh_CN' : 'en' ?>"><?= $app[$lang]['lang'] ?></a>
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
		GLOBAL $app;
		GLOBAL $lang;
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
				<?= $app[$lang]['checkLastTime'] ?>
			</a>
			<div style="text-align:left;padding-left:10px;"><?php echo $row[$lang == 'en' ? 'eng' : 'value'];?></div>
		</div>
<?php
	}
?>