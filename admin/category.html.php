<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Dettaglio categoria</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
	<link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
	<link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
	<link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
	<style>
		.mdc-textfield, .mdc-select {
			width: 90%;
			margin-left: auto;
			margin-right: auto;
		}

		.mdc-select {
			margin-top: 16px;
			margin-bottom: 16px;
			font-size: 0.95em;
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
		<form method="post" id="userform"  class="mdc-elevation--z5" style="width: 50%; text-align: center; margin: auto" onsubmit="submit_data()">
			<div class="mdc-textfield" data-mdc-auto-init="MDCTextfield">
				<input type="text" required id="sub" name="sub" class="mdc-textfield__input" value="<?php if (isset($category)) echo $category->getName() ?>">
				<label class="mdc-textfield__label" for="sub">Nome</label>
			</div>
            <div class="mdc-textfield" data-mdc-auto-init="MDCTextfield">
                <input type="text" required id="code" name="code" class="mdc-textfield__input" value="<?php if (isset($category)) echo $category->getCode() ?>">
                <label class="mdc-textfield__label" for="code">Codice</label>
            </div>
            <div class="mdc-textfield mdc-textfield--textarea" data-mdc-auto-init="MDCTextfield">
                <textarea id="textarea" name="textarea" class="mdc-textfield__input" rows="8" cols="40"><?php if (isset($category)) echo $category->getDescription() ?></textarea>
                <label for="textarea" class="mdc-textfield__label">Descrizione</label>
            </div>
			<select class="mdc-select" name="parent" id="parent">
				<option value="0">Nessuna</option>
				<?php
				while ($row = $res_cats->fetch_assoc()) {
					$selected = '';
					if (isset($category) && $category->getParent() == $row['cid']) {
						$selected = "default selected";
					}
					?>
					<option <?php echo $selected ?> value="<?php echo $row['cid'] ?>"><?php echo $row['name'] ?></option>
					<?php
				}
				?>
			</select>
            <section class="mdc-card__actions">
				<button id="submit_btn" onclick="submit_data(event)" class="mdc-button mdc-button--compact mdc-card__action">Registra</button>
			</section>
		</form>

	</div>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();
    mdc.textfield.MDCTextfield.attachTo(document.querySelector('.mdc-textfield'));

    var cid = <?php if (isset($_REQUEST['cid'])) echo $_REQUEST['cid']; else echo 0 ?>;

    var submit_data = function (event) {
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        var form = document.getElementById('userform');
        var formData = new FormData(form);

        xhr.open('post', 'category_manager.php');
        var action = <?php if ($_REQUEST['cid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

        formData.append('cid', cid);
        formData.append('action', action);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    j_alert("alert", xhr.response.message);
                    window.setTimeout(function () {
                        //window.location = 'categories.php';
                    }, 2500);
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

    document.addEventListener("DOMContentLoaded", function () {
        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - 1024) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
    });
</script>
</body>
</html>