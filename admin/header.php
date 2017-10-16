<header id="header">
	<div id="sc_firstrow">
		<i class="material-icons" style="font-size: 1.6em">school</i>
		<span style="position: relative; bottom: 8px; margin-left: 5px"><?php echo $_SESSION['__config__']['software_name']." ".$_SESSION['__config__']['software_version'] ?></span>
	</div>
	<div id="sc_secondrow">
		<i class="material-icons" style="position: relative; top: 1px">person</i>
		<span style="position: relative; margin-left: 5px; bottom: 5px">
			<?php echo $_SESSION['__user__']->getFullName() ?>
		</span>
	</div>
</header>