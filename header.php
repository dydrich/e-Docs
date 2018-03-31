<header id="header">
	<div id="sc_firstrow">
		<i class="material-icons" style="font-size: 1.6em">school</i>
		<span style="position: relative; bottom: 8px; margin-left: 5px">e-Docs 0.6 - </span>
		<span style="position: relative; bottom: 8px; font-size: 0.9em; font-weight: normal">Software di condivisione e archiviazione materiali didattici</span>
	</div>
	<div id="sc_secondrow">
		<?php
		if (isset($_SESSION['__user__'])) {
			?>
			<i class="material-icons" style="position: relative; top: 1px">person</i>
			<span style="position: relative; margin-left: 5px; bottom: 5px">
                <a href="#" onclick="show_user_menu(event, 'access_menu', 200)">
                    <?php echo $_SESSION['__user__']->getFullName() ?>
                    <i id="arrow" class="material-icons" style="position: relative; top: 8px">arrow_drop_down</i>
                </a>
            </span>
			<?php
		}
		else {
			?>
			<i class="material-icons" style="position: relative; top: 1px">lock</i>
			<span style="position: relative; margin-left: 5px; bottom: 5px">
                <a href="#" onclick="show_sign_menu(event, 'login', 320)">
                    Login
                </a>
            </span>
			<i class="material-icons" style="position: relative; top: 1px; margin-left: 15px">person_outline</i>
			<span style="position: relative; margin-left: 5px; bottom: 5px">
                <a href="#" onclick="show_sign_menu(event, 'signup', 320)">
                    Registrati
                </a>
            </span>
			<?php
		}
		?>
	</div>
</header>