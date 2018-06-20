<?php
	session_start();
	include_once "./backEnd/config.php";
	include_once "./samethings.php";
	$project = $_SESSION['project'];
	$year = $_SESSION['year'];
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
	</div>
	<div class="content">
		<div class="main">
			<div class="vote-gather">
				<span class="gather-head head">
<?php
			if ($year == date("Y")){
				$sql = "SELECT * FROM `setting` WHERE `name`='subTitle'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
				echo $row[$lang == 'en' ? 'eng' : 'value'];
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
			<div class="vote-per vote-stat">
				<h2><?= $app[$lang]['summary'] ?></h2>
				<ul class="vote-stat-per">
<?php
				$color = array("b9d53e", "09bdf0", "8684ee", "f26a6a", "efdb2b", "eb3294");
				$sql = "SELECT * FROM `{$project}_candidate_{$year}` ORDER BY `vote` DESC";
				$result = mysqli_query($conn, $sql);
				$i = 0;
				$biggest = 1;
				while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
					if ($i ++ == 0) $biggest = intval($row['vote']);
					$rate = $row['vote'] / $biggest;
?>
					<li>
						<div style="width: 120px;"><?php echo $row['name'];?></div>
						<div class="vote-pro" style="background-color:#<?php echo $color[rand(0,5)];?>;width: <?php echo $rate * 500;?>px;"></div>
						<div class="vote-stat-num"><?php echo $row['vote'];?></div>
					</li>
<?php
				}
?>
				</ul>
			</div>
			<?php tail();?>
		</div>
	</div>
</body>
</html>