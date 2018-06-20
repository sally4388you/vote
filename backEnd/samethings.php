<?php
	
	include_once "language.php";

	function turnpage_show($project, $year){
		GLOBAL $page, $total;
		GLOBAL $app, $lang;
?>
		<div id="link_valid">
			<a <?php if ($page > 1) {?>href="?project=<?= $project ?>&year=<?= $year ?>&page=1"<?php }?>><?= $app[$lang]['first_page'] ?></a>
			<a <?php if ($page > 1) {?>href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $page-1 ?>"<?php }?>><?= $app[$lang]['last_page'] ?></a>
		<?php if ($page > 2) {?>
			<a href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $page-2 ?>"><?= $page-2 ?></a>
		<?php }?>
		<?php if ($page > 1) {?>
			<a href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $page-1?>"><?= ($page > 1) ? $page-1 : '' ?></a>
		<?php }?>

			<?= $page."&nbsp;" ?>

		<?php if ($page < $total) {?>
			<a href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $page+1?>"><?= $page+1 ?></a>
		<?php }?>
		<?php if ($page < ($total - 2)) {?>
			<a href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $page+2?>"><?= $page+2 ?></a>
		<?php }?>
			<a <?php if ($page < $total) {?>href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $page+1 ?>"<?php }?>><?= $app[$lang]['next_page'] ?></a>
			<a <?php if ($page < $total) {?>href="?project=<?= $project ?>&year=<?= $year ?>&page=<?= $total ?>"<?php }?>><?= $app[$lang]['last_page'] ?></a>
			<?= $total;?> <?= $app[$lang]['total_page'] ?>
		</div>
<?php
	}
?>