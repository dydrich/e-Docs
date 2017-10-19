<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Configurazione del sito</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.jeditable.mini.js"></script>
    <script>
        $(function(){
            load_jalert();
            setOverlayEvent();
            $('.edit').editable('env_manager.php', {
                indicator : 'Saving...',
                tooltip   : 'Click to edit...'
            });
        });
    </script>
	<style>
		.demo-card {
			width: 320px;
			height: 120px;
			margin-left: 25px;
			margin-bottom: 25px;
		}

		.mdc-button--compact {
			font-size: 1em;
		}

		.app-fab--absolute.app-fab--absolute {
			position: fixed;
			right: 31.9rem;
		}
	</style>
</head>
<body>
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
<div id="main">
	<div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
	<div id="left_col">
        <div class="mdc-elevation--z5" style="width: 80%; padding: 20px; margin: auto">
            <table class="admin_table" style="width: 95%; border-collapse: collapse">
                <tr class="accent_decoration">
                    <td style="width: 40%; padding-left: 10px; font-weight: bold">Variabile</td>
                    <td style="width: 60%; padding-left: 10px; font-weight: bold">Valore</td>
                </tr>
				<?php
				$res_env->data_seek(0);
				while($row = $res_env->fetch_assoc()){
					$k = $row['var'];
					$v = $row['value'];
					?>
                    <tr style="height: 30px">
                        <td style="width: 40%; padding-left: 10px" id=""><?php print $k ?></td>
                        <td style="width: 60%; padding-left: 10px;">
                            <p id="<?php print $k ?>" class="edit" style="margin-top: auto; margin-bottom: auto"><?php echo stripslashes($v) ?></p>

                        </td >
                    </tr>
				<?php } ?>
            </table>
        </div>
	</div>
	<button id="newvalue" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo valore">
        <span class="mdc-fab__icon">
            create
        </span>
	</button>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script type="application/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        var coord = document.body.getBoundingClientRect();
        var height = coord.height;
        var btn = document.getElementById('newvalue');
        btn.style.top = (height - 100)+"px";
    });

    var btn = document.getElementById('newvalue');
    btn.addEventListener('click', function (event) {
        event.preventDefault();

    });
</script>
</body>
</html>