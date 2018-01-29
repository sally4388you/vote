<?php
	session_start();
	include_once "./backEnd/config.php";
	include_once "./samethings.php";
	$sql = "SELECT * FROM `projectname` WHERE `isshowed`='1'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_BOTH);
	$project = $row['eng_name'];
	if (isset($_GET['backyear'])){
		$year = intval(date("Y")) - 1;
		setcookie('back', '1');
	}
	else{
		$year = date("Y");
		setcookie('back', '0', time()-3600);
	}
	$_SESSION['project'] = $project;
	$_SESSION['year'] = $year;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>华中科技大学投票系统</title>
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
			if (isset($_GET['backyear'])){
				echo "<a href='index.php'>返回本期投票 ></a>";
			}
			else{
				$sql = "SELECT * FROM `setting` WHERE `name`='subTitle'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
				echo $row['value'];
			}
?>
				</span>
				<a href="vote-stat.php">查看所有投票结果 ></a>
				<div class="clear_div"></div>
			</div>
			<div class="vote-per vote-main">
				<ul>
<?php
				if (!isset($_SESSION['order'])){
					$sql = "SELECT `id`,`vote`,`name`,`department`,`studentid` FROM `{$project}_candidate_{$year}` ORDER BY rand()";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
						$arr[] = $row;
					}
					shuffle($arr);
					$_SESSION['order'] = $arr;
				}
				else $arr = $_SESSION['order'];
				for ($i = 0; $i < count($arr); $i ++){
					$encryptionid = mt_rand(100,999).strlen($arr[$i]['id']).$arr[$i]['id'].mt_rand(100,999);
					$bar = (intval($arr[$i]['vote']) > 626) ? 188 : intval($arr[$i]['vote']) * 0.3;
?>
					<li class="vote-per-box">
						<img src="./photos/<?php echo $project."_".$year."/".strtolower($arr[$i]['studentid']);?>.jpg" alt="">
						<p class="vote-per-name"><?php echo $arr[$i]['name'];?></p>
						<p class="vote-per-major"><?php echo $arr[$i]['department'];?></p>
						<div class="vote-per-progress">
							<div class="vote-progress-bg"></div>
							<div class="vote-progress-num" style="width: <?php echo $bar;?>px;"></div>
						</div>
						<p class="vote-per-num"><?php echo $arr[$i]['vote'];?>票</p>
						<a href="javascript:void(0)" class="vote-per-btn" onclick="vote(<?php echo $encryptionid;?>);">投  票</a>
					</li>
<?php
				}
?>
				</ul>
			</div>
			<?php tail();?>
		</div>
	</div>
	<script type="text/javascript">
		// checkvoted();
	</script>
</body>
</html>