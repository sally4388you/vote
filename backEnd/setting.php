<?php

	if (isset($_POST['firstTitle'])){
		$firstTitle = $_POST['firstTitle'];
		$subTitle = $_POST['subTitle'];
		$tail = $_POST['tail'];
		$opentime = $_POST['opentime'];
		$closetime = $_POST['closetime'];
		$votetime = $_POST['votetime'];
		$sql = "UPDATE `setting` SET `value`='{$firstTitle}' WHERE `name`='firstTitle'";mysqli_query($conn, $sql);
		$sql = "UPDATE `setting` SET `value`='{$subTitle}' WHERE `name`='subTitle'";mysqli_query($conn, $sql);
		$sql = "UPDATE `setting` SET `value`='{$opentime}' WHERE `name`='opentime'";mysqli_query($conn, $sql);
		$sql = "UPDATE `setting` SET `value`='{$closetime}' WHERE `name`='closetime'";mysqli_query($conn, $sql);
		$sql = "UPDATE `setting_long` SET `value`='{$tail}' WHERE `name`='tail'";mysqli_query($conn, $sql);
		$sql = "UPDATE `setting` SET `value`='{$votetime}' WHERE `name`='votetime'";mysqli_query($conn, $sql);
		echo "<script>alert('保存成功');</script>";
	}

	function show()
	{
		GLOBAL $conn, $type;
		try
		{
?>
			<script src="../js/laydate.js"></script>
			<table class="maintable" cellspacing="1" cellpadding="4">
			    <form action="./dataprocess/upload.php?type=voter" enctype="multipart/form-data" method="post">
				<tr><td colspan="5">
						导入投票人
		            	选择要导入的excel文件:
		            	<input name="info" type="file" />
		            	<input type="submit" value="上传" />(表格按照学号，姓名，身份证后6位的顺序)
				</td></tr>
			    </form>
				<tr>
					<td>已导入的学生信息</td>
					<td colspan="4">
<?php
				$yearNow = intval(Date("Y")) - 10;
				$sql = "SELECT * FROM `setting` WHERE `name`='voter' AND `value` > {$yearNow} ORDER BY `value` DESC";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
					echo "&nbsp".$row['value']."年&nbsp;|";
				}
				echo " ...";
?>
					</td>
				</tr>
				<form action="?projectdelete=1" method="post" onsubmit="return confirm('确定删除？');">
				<tr id="project" class="button">
					<td rowspan="3">已添加的投票项目</td>
					<td><input type="submit" id="deletebutton" style="display:none;" value="删除"></td>
					<td></td>
					<td></td>
					<td rowspan="3">
						<font color="red">*注意事项：</font>添加的投票项目只能有一项正在开放,点击图标即可修改开放状态;<br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						一次删除的点击只能删除一个项目的某一年或某几年记录.<br />	
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						项目后的年份只与删除操作有关，与是否开放此年度项目投票无关
					</td>
				</tr>
<?php
				$sql = "SELECT * FROM `projectname`";$i = 0;
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
					$isshowed = ($row['isshowed'] == 0) ? "no" : "yes";
					$i += 1;
?>
				<tr>
					<td class="projectDelete"><input name="projectname" type="checkbox" value="<?php echo $row['eng_name'];?>" onclick="projectDelete(this)"></td>
					<td>
						<?php echo $row['ch_name'];?>
						<select name="year" disabled>
<?php
					$_sql = "SELECT DISTINCT `value` FROM `setting` WHERE `name`='{$row['eng_name']}'";
					$_result = mysqli_query($conn, $_sql);
					while ($_row = mysqli_fetch_array($_result, MYSQLI_BOTH)){
?>
							<option><?php echo $_row['value'];?></option>
<?php
					}
?>
							<option>所有年份</option>
						</select>
					</td>
					<td>
						<input type="image" id="isshowpicture<?php echo $row['id'];?>" src="../images/<?php echo $isshowed;?>.png" value="<?php echo $row['isshowed'];?>" onclick="isshow('<?php echo $row['id'];?>',this.value);return false;" class="showbutton">
					</td>
				</tr>
<?php
				}
				$sql = "SELECT * FROM `setting` WHERE `name`='opentime'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
				$opentime = $row['value'];
				$sql = "SELECT * FROM `setting` WHERE `name`='closetime'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
				$closetime = $row['value'];
?>
				</form>
				<form action="" method="post" onsubmit="return checktime(this);">
				<tr>
					<td>投票时间</td>
					<td colspan="4">
						<input name="opentime" class="laydate-icon" onclick="laydate()" value="<?php echo $opentime;?>">至
						<input name="closetime" class="laydate-icon" id="demo" value="<?php echo $closetime;?>">
					</td>
				</tr>
<?php
				$titlename = array('firstTitle' => '标题', 'subTitle' => '小标题', 'tail' => '页尾');
				$sql = "SELECT * FROM `setting` WHERE `id`='9' OR `id`='10'";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
?>
				<tr>
					<td><?php echo $titlename[$row['name']];?></td>
					<td colspan="4"><input name="<?php echo $row['name'];?>" type="text" value="<?php echo $row['value'];?>" /></td>
				</tr>
<?php
				}
				$sql = "SELECT * FROM `setting_long` WHERE `name`='tail'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
?>
				<tr>
					<td><?php echo $titlename[$row['name']];?></td>
					<td colspan="4"><textarea name="<?php echo $row['name'];?>" style="width:400px;height:100px;"><?php echo $row['value'];?></textarea></td>
				</tr>
<?php
				$sql = "SELECT * FROM `setting` WHERE `name`='votetime'";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_array($result, MYSQLI_BOTH);
?>
				<tr>
					<td>投票次数</td>
					<td colspan="4"><input name="<?php echo $row['name'];?>" value="<?php echo $row['value'];?>"></td>
				</tr>
				<tr><td colspan="5"><input type="submit" value="保存"></td></tr>
				</form>
			</table>
			<script type="text/javascript">
				;!function(){laydate({elem: '#demo'})}();
				var tds = document.getElementById('project').getElementsByTagName('td');
				tds[0].rowSpan = "<?php echo ($i + 1);?>";
				tds[4].rowSpan = "<?php echo ($i + 1);?>";
			</script>
<?php
		}
		catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
?>