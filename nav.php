<nav id="navigation">
	<div id="head_label" style="display: flex; align-items: center; padding-left: 15px">
		<?php if (!isset($_GET['back'])) : ?>
			<i class="material-icons" id="open_drawer" style="float: left; font-size: 1.8em">menu</i>
		<?php else : ?>
			<a href="<?php echo $_GET['back'] ?>">
				<i class="material-icons" id="open_drawer" style="float: left; font-size: 1.8em">arrow_back</i>
			</a>
		<?php endif; ?>
		<p id="drawer_label" style="margin-left: 10px; float: left"><?php echo $drawer_label ?></p>
	</div>
</nav>