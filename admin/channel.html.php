<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Dettaglio canale</title>
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

		.mdc-text-field, .mdc-select {
			width: 90%;
			margin-left: auto;
			margin-right: auto;
		}

		.mdc-select {
			font-size: 0.95em;
            height: 56px!important;
		}

        .mdc-select--outlined .mdc-floating-label {
            bottom: 25px;
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
		<form method="post" id="channelform"  class="mdc-elevation--z5" style="width: 50%; text-align: center; margin: auto; padding: 10px" onsubmit="submit_data()">
			<div class="mdc-text-field" data-mdc-auto-init="MDCTextField">
				<input type="text" required id="name" name="name" class="mdc-text-field__input" value="<?php if(isset($channel)) echo $channel->getName() ?>">
				<label class="mdc-floating-label" for="name">Nome</label>
			</div>
            <div class="mdc-text-field mdc-text-field--textarea" data-mdc-auto-init="MDCTextField" style="margin-top: 10px; margin-bottom: 30px">
                <textarea id="textarea" required name="desc" class="mdc-text-field__input" rows="8" cols="40"><?php if (isset($channel)) echo $channel->getDescription() ?></textarea>
                <label for="textarea" class="mdc-floating-label">Descrizione</label>
            </div>
            <div class="mdc-select mdc-select--outlined" style="" data-mdc-auto-init="MDCSelect">
                <select class="mdc-select__native-control" name="subject" id="subject">
                    <option value="0">Nessuna</option>
					<?php
					while ($row = $res_subs->fetch_assoc()) {
						$selected = '';
						if (isset($channel) && $channel->getSubject() == $row['sid']) {
							$selected = "default selected";
						}
						?>
                        <option <?php echo $selected ?> value="<?php echo $row['sid'] ?>"><?php echo $row['name'] ?></option>
						<?php
					}
					?>
                </select>
                <label class="mdc-floating-label mdc-floating-label--float-above">Area disciplinare</label>
                <div class="mdc-notched-outline">
                    <svg>
                        <path class="mdc-notched-outline__path"></path>
                    </svg>
                </div>
                <div class="mdc-notched-outline__idle"></div>
            </div>
            <div class="mdc-select mdc-select--outlined" style="margin-top: 30px" data-mdc-auto-init="MDCSelect">
                <select class="mdc-select__native-control" name="school" id="school">
                    <option value="0">Tutte</option>
					<?php
					while ($row = $res_schools->fetch_assoc()) {
						$selected = '';
						if (isset($channel) && $channel->getSchool() == $row['sid']) {
							$selected = "default selected";
						}
						?>
                        <option <?php echo $selected ?> value="<?php echo $row['sid'] ?>"><?php echo $row['name'] ?></option>
						<?php
					}
					?>
                </select>
                <label class="mdc-floating-label mdc-floating-label--float-above">Scuola</label>
                <div class="mdc-notched-outline">
                    <svg>
                        <path class="mdc-notched-outline__path"></path>
                    </svg>
                </div>
                <div class="mdc-notched-outline__idle"></div>
            </div>
            <div class="mdc-select mdc-select--outlined" style="margin-top: 30px" data-mdc-auto-init="MDCSelect">
                <select class="mdc-select__native-control" name="grade" id="grade">
                    <option value="0">Tutte</option>
					<?php
					while ($row = $res_grades->fetch_assoc()) {
						$selected = '';
						if (isset($channel) && $channel->getGrade() == $row['grade']) {
							$selected = "default selected";
						}
						?>
                        <option <?php echo $selected ?> value="<?php echo $row['grade'] ?>"><?php echo $row['description'] ?></option>
						<?php
					}
					?>
                </select>
                <label class="mdc-floating-label mdc-floating-label--float-above">Classe</label>
                <div class="mdc-notched-outline">
                    <svg>
                        <path class="mdc-notched-outline__path"></path>
                    </svg>
                </div>
                <div class="mdc-notched-outline__idle"></div>
            </div>
            <fieldset style="width: 90%; margin-right: auto; margin-left: auto; border-color:rgba(0, 0, 0, .3) ">
                <legend style="text-align: left; font-weight: normal; color: rgba(0, 0, 0, .6); font-size: 0.9em">Sottocanale di</legend>
                <div class="mdc-form-field" data-mdc-auto-init="MDCFormField" style="width: 90%;">
					<?php
					$index = 0;
					while ($ch = $res_channels->fetch_assoc()) {
					    $checked = '';
					    if (isset($channel) && in_array($ch['idc'], $channel->getParents())) {
					        $checked = 'checked';
                        }
					    if ($index != 0 && $index%3 == 0) {
					?>
                </div>
                <div class="mdc-form-field" data-mdc-auto-init="MDCFormField" style="width: 90%;">
					<?php
					}
					?>
                    <div class="mdc-checkbox" data-mdc-auto-init="MDCCheckbox">
                        <input type="checkbox" class="mdc-checkbox__native-control" <?php echo $checked ?> name="subchannel-of[]" id="checkbox-<?php echo $ch['idc'] ?>" value="<?php echo $ch['idc'] ?>"/>
                        <div class="mdc-checkbox__background">
                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                            </svg>
                            <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                    </div>
                    <label for="checkbox-<?php echo $ch['idc'] ?>"><?php echo $ch['name'] ?></label>
					<?php
					$index++;
					}
					?>
                </div>
            </fieldset>
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
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));
    mdc.formField.MDCFormField.attachTo(document.querySelector('.mdc-form-field'));

    var cid = <?php if (isset($_REQUEST['cid'])) echo $_REQUEST['cid']; else echo 0 ?>;

    var submit_data = function (event) {
        fade('confirm', 'out', .1, 0);
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        var form = document.getElementById('channelform');
        var formData = new FormData(form);

        xhr.open('post', 'channel_manager.php');
        var action = <?php if ($_REQUEST['cid'] != 0) echo ACTION_UPDATE; else echo ACTION_INSERT ?>;

        formData.append('cid', cid);
        formData.append('system', 1);
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
                        window.location = 'channels.php';
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