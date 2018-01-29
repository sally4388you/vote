<?php

	function turnpage_show($project, $year){
		GLOBAL $page, $total;
?>
		<div id="link_valid">
			<a <?php if ($page > 1) {?>href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=1"<?php }?>>首页</a>
			<a <?php if ($page > 1) {?>href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $page-1;?>"<?php }?>>上一页</a>
		<?php if ($page > 2) {?>
			<a href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $page-2?>"><?php echo $page-2;?></a>
		<?php }?>
		<?php if ($page > 1) {?>
			<a href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $page-1?>"><?php if ($page > 1) echo $page-1;?></a>
		<?php }?>

			<?php echo $page."&nbsp;";?>

		<?php if ($page < $total) {?>
			<a href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $page+1?>"><?php echo $page+1;?></a>
		<?php }?>
		<?php if ($page < ($total - 2)) {?>
			<a href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $page+2?>"><?php echo $page+2;?></a>
		<?php }?>
			<a <?php if ($page < $total) {?>href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $page+1;?>"<?php }?>>下一页</a>
			<a <?php if ($page < $total) {?>href="?project=<?php echo $project;?>&year=<?php echo $year;?>&page=<?php echo $total;?>"<?php }?>>末页</a>
			共<?php echo $total;?>页
		</div>
<?php
	}
?>