<?php

	function show($year, $project)
	{
		GLOBAL $conn, $count;
		$filepath = "../photos/".$project.'_'.$year."/";
		try
		{
?>
			导入候选人
			<span class="bt_box bt1_box">
            	<input class="bt" value="信 息" type="button" onclick="uploadbutton('intoDB');" />
            </span>
            <span class="bt_box bt1_box">
            	<input class="bt" value="图 片" type="button" onclick="uploadbutton('uppicture');" />
            </span>

            <form action="./dataprocess/upload.php?type=candidate" enctype="multipart/form-data" method="post" id="form_intoDB">
            	选择要导入的excel文件:
				<select name="year">
					<option value="<?php echo $year;?>"><?php echo $year;?>年</option>
					<option value="<?php echo (intval($year) + 1);?>"><?php echo (intval($year) + 1);?>年</option>
				</select>
            	<input name="info" type="file" />
            	<input name="project" type="hidden" value="<?php echo $project;?>">
            	<input type="submit" value="上传" />
            </form>
            <form action="./dataprocess/upload.php?type=picture" enctype="multipart/form-data" method="post" id="form_uppicture">
            	选择要导入的图片文件:
            	<select name="year">
					<option value="<?php echo $year;?>"><?php echo $year;?>年</option>
					<option value="<?php echo (intval($year) + 1);?>"><?php echo (intval($year) + 1);?>年</option>
				</select>
            	<input name="picture[]" multiple type="file" />
            	<input name="project" type="hidden" value="<?php echo $project;?>">
            	<input type="submit" value="上传" />
            </form><br />

            <font color="red">*注意:</font>
            <div style="padding-left:50px;margin-top:-21px;">
            	导入的excel文件必须在office2007以上,表格中时间的类型必须调整为日期<br />
            	为了保证投票页面加载不至于过慢，请将导入图片尺寸：宽*高改为200像素*267像素<br />
            	导入图片必须为jpg格式,图片名称以学生学号命名&nbsp;&nbsp;&nbsp;
            	<span class="button">
            		<a href="./dataprocess/intoExcel.php?project=<?php echo $project;?>&year=<?php echo $year;?>">导出投票结果</a>
            		<a href="./dataprocess/downExcel.php">下载表格模板</a>
            	</span>
				<span class="add">
					<a href="?project=<?php echo $project;?>&year=<?php echo $year;?>&addp=1"><img src="../images/add.png" align="center"></a> 添 加
				</span>
            </div>
            <form action="<?php echo '?delete=1&project='.$project.'&year='.$year;?>" method="post">
			<table class="maintable" cellspacing="1" cellpadding="4">
				<tr class="title_tr button" align="center">
					<td width="50px"><input id="deletebutton" type="submit" value="删 除" style="display:none;" onclick="return confirm('确定删除?');"></td>
					<td>学号</td>
					<td>姓名</td>
					<td>院系</td>
					<td>添加时间</td>
					<td>票数</td>
					<td>图片</td>
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
						<a href="<?php echo '?project='.$project.'&id='.$row['id'].'&year='.$year;?>">查看</a>
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
		GLOBAL $conn;
		try
		{
			$sql = "SELECT * FROM `{$project}_candidate_{$year}` WHERE `id`='{$id}'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result, MYSQLI_BOTH);
?>
			<form action="<?php echo './dataprocess/revise.php?project='.$project.'&year='.$year.'&id='.$id;?>" method="post" id="formRevise">
			<table class="detailtable button">
				<tr class="stuimage">
					<td width="250px" height="50px">学号:&nbsp;<div><?php echo $row['studentid'];?></div></td>
					<td>姓名:&nbsp;<div><?php echo $row['name'];?></div></td>
					<td>院系:&nbsp;<div><?php echo $row['department'];?></div></td>
					<td rowspan="3" width="182px" valign="top"><img src="../photos/<?php echo $project.'_'.$year.'/'.strtolower($row['studentid']);?>.jpg"></td>
				</tr>
				<tr>
					<td colspan="2" height="50px">发布时间:&nbsp;<?php echo $row['time'];?></td>
					<td>总票数:&nbsp;<?php echo $row['vote'];?></td>
				</tr>
				<tr>
					<td colspan="3"><div>简介:&nbsp;<?php echo $row['introduction'];?></div></td>
				</tr>
				<tr>
					<td>投票学号</td>
					<td colspan="2">投票时间</td>
					<td>状态</td>
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
				<input type="button" value="修改" onclick="revise(this);" id="revisebutton" />
				<input type="button" value="取消修改" id="norevise" onclick="cancel(this);" style="display:none;">
				<input type="button" value="返回" onclick="if(confirm('确定返回?')) location.href='?project=<?php echo $project;?>&year=<?php echo $year;?>';">
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