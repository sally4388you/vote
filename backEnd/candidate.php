<?php

	function show($year, $project)
	{
		GLOBAL $conn, $count, $app, $lang;
		$filepath = "../photos/".$project.'_'.$year."/";
		try
		{
?>
			<?= $app[$lang]['upload_candid'] ?>
			<span class="bt_box bt1_box">
            	<input class="bt" value="<?= $app[$lang]['info'] ?>" type="button" onclick="uploadbutton('intoDB');" />
            </span>
            <span class="bt_box bt1_box">
            	<input class="bt" value="<?= $app[$lang]['stu_pic'] ?>" type="button" onclick="uploadbutton('uppicture');" />
            </span>

            <form action="./dataprocess/upload.php?type=candidate" enctype="multipart/form-data" method="post" id="form_intoDB">
            	<?= $app[$lang]['upload_excel'] ?>:
				<select name="year">
					<option value="<?php echo $year;?>"><?php echo $year;?><?= $app[$lang]['year'] ?></option>
					<option value="<?php echo (intval($year) + 1);?>"><?php echo (intval($year) + 1);?><?= $app[$lang]['year'] ?></option>
				</select>
            	<input name="info" type="file" />
            	<input name="project" type="hidden" value="<?php echo $project;?>">
            	<input type="submit" value="<?= $app[$lang]['upload'] ?>" />
            </form>
            <form action="./dataprocess/upload.php?type=picture" enctype="multipart/form-data" method="post" id="form_uppicture">
            	<?= $app[$lang]['upload_pic'] ?>:
            	<select name="year">
					<option value="<?php echo $year;?>"><?php echo $year;?><?= $app[$lang]['year'] ?></option>
					<option value="<?php echo (intval($year) + 1);?>"><?php echo (intval($year) + 1);?><?= $app[$lang]['year'] ?></option>
				</select>
            	<input name="picture[]" multiple type="file" />
            	<input name="project" type="hidden" value="<?php echo $project;?>">
            	<input type="submit" value="<?= $app[$lang]['upload'] ?>" />
            </form><br />

            <font color="red">*<?= $app[$lang]['attention'] ?>:</font>
            <div style="padding-left:50px;margin-top:-21px;">
            	<?= $app[$lang]['attention_msg1'] ?><br />
            	<?= $app[$lang]['attention_msg2'] ?><br />
            	<?= $app[$lang]['attention_msg3'] ?>&nbsp;&nbsp;&nbsp;
            	<span class="button">
            		<a href="./dataprocess/intoExcel.php?project=<?php echo $project;?>&year=<?php echo $year;?>"><?= $app[$lang]['export'] ?></a>
            		<a href="./dataprocess/downExcel.php"><?= $app[$lang]['template'] ?></a>
            	</span>
				<span class="add">
					<a href="?project=<?php echo $project;?>&year=<?php echo $year;?>&addp=1"><img src="../images/add.png" align="center"></a> <?= $app[$lang]['add_btn'] ?>
				</span>
            </div>
            <form action="<?php echo '?delete=1&project='.$project.'&year='.$year;?>" method="post">
			<table class="maintable" cellspacing="1" cellpadding="4">
				<tr class="title_tr button" align="center">
					<td width="50px"><input id="deletebutton" type="submit" value="删 除" style="display:none;" onclick="return confirm('确定删除?');"></td>
					<td><?= $app[$lang]['stu_id'] ?></td>
					<td><?= $app[$lang]['stu_name'] ?></td>
					<td><?= $app[$lang]['stu_school'] ?></td>
					<td><?= $app[$lang]['postTime'] ?></td>
					<td><?= $app[$lang]['stu_votes'] ?></td>
					<td><?= $app[$lang]['stu_pic'] ?></td>
					<td width="100px"></td>
				</tr>
<?php
			$i = 1;
			$sql = "SELECT * FROM `{$project}_candidate_{$year}` LIMIT {$count},20";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
			{
				$i += 1;
				if ($row['studentid'] == "id"){
					$_sql = "DELETE FROM `{$project}_candidate_{$year}` WHERE `id`='{$row['id']}'";
					mysqli_query($conn, $_sql);
					continue;
				}
?>
				<tr class="projectDelete" align="center" bgcolor="white">
					<td><input name="deleteid[]" type="checkbox" value="<?php echo $row['id'];?>" onclick="studentDelete();" /></td>
					<td><?php echo $row['studentid'];?></td>
					<td><?php echo $row['name'];?></td>
					<td><?php echo $row['department'];?></td>
					<td><?php echo $row['time'];?></td>
					<td><?php echo $row['vote'];?>
					</td>
					<td><img src="../images/<?php echo (is_readable($filepath.strtolower($row['studentid'].".jpg"))) ? 'yes' : 'no';?>.png"></td>
					<td class="button">
						<a href="<?php echo '?project='.$project.'&id='.$row['id'].'&year='.$year;?>"><?= $app[$lang]['check_btn'] ?></a>
					</td>
				</tr>
<?php
			}
?>
			</table>
			</form>
<?php
		}
		catch (Exception $e)
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

	function detail($id, $year, $project)
	{
		GLOBAL $conn, $app, $lang;
		try
		{
			$sql = "SELECT * FROM `{$project}_candidate_{$year}` WHERE `id`='{$id}'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result, MYSQLI_BOTH);
?>
			<form action="<?php echo './dataprocess/revise.php?project='.$project.'&year='.$year.'&id='.$id;?>" method="post" id="formRevise">
			<table class="detailtable button">
				<tr class="stuimage">
					<td width="250px" height="50px"><?= $app[$lang]['stu_id'] ?>:&nbsp;<div><?php echo $row['studentid'];?></div></td>
					<td><?= $app[$lang]['stu_name'] ?>:&nbsp;<div><?php echo $row['name'];?></div></td>
					<td><?= $app[$lang]['stu_school'] ?>:&nbsp;<div><?php echo $row['department'];?></div></td>
					<td rowspan="3" width="182px" valign="top">
						<!-- <img src="../photos/<?php // echo $project.'_'.$year.'/'.strtolower($row['studentid']);?>.jpg"> -->
						<img src="../photos/photo.png">
					</td>
				</tr>
				<tr>
					<td colspan="2" height="50px"><?= $app[$lang]['postTime'] ?>:&nbsp;<?php echo $row['time'];?></td>
					<td><?= $app[$lang]['stu_votes'] ?>:&nbsp;<?php echo $row['vote'];?></td>
				</tr>
				<tr>
					<td colspan="3"><div><?= $app[$lang]['stu_intro'] ?>:&nbsp;<?php echo $row['introduction'];?></div></td>
				</tr>
				<tr>
					<td><?= $app[$lang]['vote_id'] ?></td>
					<td colspan="2"><?= $app[$lang]['vote_time'] ?></td>
					<td><?= $app[$lang]['vote_status'] ?></td>
				</tr>
<?php
			$_sql = "SELECT * FROM `{$project}_vote_{$year}` WHERE `kid`='{$id}'";
			$_result = mysqli_query($conn, $_sql);
			while ($_row = mysqli_fetch_array($_result, MYSQLI_BOTH)){
?>
				<tr>
					<td><?php echo $_row['studentid'];?></td>
					<td colspan="2"><?php echo $_row['time'];?></td>
					<td><?php echo $_row['state'];?></td>
				</tr>
<?php
			}
?>
			</table>
			<div id="submitbutton">
				<input type="button" value="<?= $app[$lang]['submit'] ?>" onclick="revise(this);" id="revisebutton" />
				<input type="button" value="<?= $app[$lang]['cancel_btn'] ?>" id="norevise" onclick="cancel(this);" style="display:none;">
				<input type="button" value="<?= $app[$lang]['return_btn'] ?>" onclick="if(confirm('<?= $app[$lang]['return_msg'] ?>')) location.href='?project=<?php echo $project;?>&year=<?php echo $year;?>';">
			</div>
			</form>
			<script type="text/javascript" charset="utf-8" src="../ueditor/ueditor.config.js"></script>
			<script type="text/javascript" charset="utf-8" src="../ueditor/ueditor.all.js"></script>
<?php
			if (isset($_GET['revise'])) echo "<script>revise(revisebutton);</script>";
		}
		catch (Exception $e)
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
?>