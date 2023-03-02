<?php #файл запускает все файлы html в один,
include "header.tpl.php";
include "menu.tpl.php";
?>
<div id="center">
	<div id="side_bar">
		<?php include "side_bar.tpl.php";?>
	</div>
	<div id="content">
		<?=$content;?>
	</div>
	<div style="clear:both"></div>
</div>

<?php include "footer.tpl.php";?>