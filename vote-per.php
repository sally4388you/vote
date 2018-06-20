<?php

	session_start();
	include_once "./backEnd/config.php";
	include_once "./samethings.php";
	if (!isset($_SESSION['project'])){
		echo "<script>location.href='index.php';</script>";
		die();
	}
	$project = $_SESSION['project'];
	$year = $_SESSION['year'];
	if (!$_COOKIE['clandestine']){
		echo "<script>location.href='index.php';</script>";
		die();
	}
	$encryptionid = $_COOKIE['clandestine'];
	$count = substr($encryptionid, 3, 1);
	$id = substr($encryptionid, 4, $count);

	$sql = "SELECT * FROM `{$project}_candidate_{$year}` WHERE `id`='{$id}'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_BOTH);
	$bar = (intval($row['vote']) > 626) ? 188 : intval($row['vote']) * 0.3;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $app[$lang]['title'] ?></title>
	<link href="./css/main.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="./js/main.js"></script>
</head>
<body>
	<?php head();?>
	<div class="content">
		<div class="main">
			<div class="vote-gather">
				<span class="gather-head head">
<?php
			if ($year == date("Y")){
				$_sql = "SELECT * FROM `setting` WHERE `name`='subTitle'";
				$_result = mysqli_query($conn, $_sql);
				$_row = mysqli_fetch_array($_result, MYSQLI_BOTH);
				echo $_row[$lang == 'en' ? 'eng' : 'value'];
			}
?>
				</span>
<?php
			if ($year != date("Y")){
				echo "<a href='index.php?backyear=1'>返回往期投票首页 ></a>";
			}
			else echo "<a href='index.php'>". $app[$lang]['back'] ." ></a>";
?>
				<div class="clear_div"></div>
			</div>
			<form action="" method="post">
			<div class="vote-per vote-per-content">
				<h2><?= $app[$lang]['nominee'] ?>————<?php echo $row['name'];?></h2>
				<div class="divide"></div>
				<p class="vote-per-time"><?= $app[$lang]['postTime'] ?><?php echo $row['time'];?></p>
				<div class="vote-per-box">
					<!-- <img src="./photos/<?php //echo $project."_".$year."/".strtolower($row['studentid']);?>.jpg" alt=""> -->
					<img src="./photos/photo.png" alt="">
					<div class="vote-per-progress">
						<div class="vote-progress-bg"></div>
						<div class="vote-progress-num" style="width: <?php echo $bar;?>px;"></div>
					</div>
					<p class="vote-per-num"><?php echo $row['vote'];?> <?= $app[$lang]['ammount'] ?></p>
					<input type="submit" value="<?= $app[$lang]['vote'] ?>" class="vote-per-btn">
					<input name="wondnte" type="hidden" value="<?php echo $encryptionid;?>">
				</div>
				<div class="vote-per-intro">
					<?php echo $row['introduction'];?>
				</div>
				<div class="clear_div"></div>
			</div>
			</form>
			<?php tail();?>
		</div>
	</div>
    <div id="cover">
    	<div id="votesuc">
    		投 票 成 功!
    		<div>投票次数还有<span id="votetime">1</span>次</div><br /><br />
    		<a href="index.php">确 认</a>
    	</div>
    </div>
	<script type="text/javascript">
		// checkvoted();
	</script>
	<?php include_once "./voteaction.php";?>
</body>
</html>