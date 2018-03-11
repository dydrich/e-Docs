<!DOCTYPE html>
<html class="mdc-typography">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Modifica password</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
	<link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
	<link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
	<link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
	<script type="application/javascript" src="../js/md5-min.js"></script>
	<style>
		.mdc-text-field {
			width: 100%;
		}

		form {
			border: 0;
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
		<div id="login_form" class="mdc-elevation--z3" style="width: 50%; margin: auto; display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center; justify-content: center">
			<form id='myform' method='post' action='#' style="width: 90%; margin: auto">
				<h3 style="margin-top: 0">Modifica password</h3>
				<div style="display: block; width: 100%">
					<div class="mdc-text-field" data-mdc-auto-init="MDCTextField">
						<input required type="password" id="pwd1" name="pwd1" class="mdc-text-field__input">
						<label class="mdc-floating-label" for="pwd1">Inserisci la password</label>
					</div>
				</div>
				<div style="display: block; width: 100%">
					<div class="mdc-text-field" data-mdc-auto-init="MDCTextField">
						<input required type="password" class="mdc-text-field__input" id="pwd2" name="pwd2">
						<label for="pwd2" class="mdc-floating-label">Ripeti la password</label>
						<div class="mdc-text-field__bottom-line"></div>
					</div>
				</div>
				<button type="button" class="mdc-button mdc-button--raised" style="margin-top: 20px" id="mail_button">
					Invia
				</button>
			</form>
		</div>
	</div>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script type="text/javascript">
    window.mdc.autoInit();
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));

    (function() {
        load_jalert();
        var btn = document.getElementById('mail_button');
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            registra();
        });
    })();

    var registra = function (){
        var patt = /[^a-zA-Z0-9]/;
        if(document.getElementById('pwd1').value === ""){
            j_alert('error', "Password non valida.");
            return false;
        }
        else if(document.getElementById('pwd1').value.match(patt)){
            j_alert('error', "Password non valida: sono ammessi solo lettere e numeri");
            return false;
        }
        if(document.getElementById('pwd1').value !== document.getElementById('pwd2').value){
            j_alert('error', "Le password inserite sono differenti. Ricontrolla.");
            return false;
        }
        p = hex_md5(document.getElementById('pwd1').value);

        var uid = <?php echo $uid ?>;

        var url = "password_manager.php";

        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', '../share/account_manager.php');
        var action = 'change_personal_password';
        formData.append('uid', uid);
        formData.append('action', action);
        formData.append('new_pwd', p);

        xhr.responseType = 'json';
        xhr.send(formData);

        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    if (xhr.response.status === 'ok') {
                        j_alert("alert", xhr.response.message);
                        setTimeout(function(){
                            window.location = "index.php";
                        }, 2000);
                    }
                    else if (xhr.response.status === "nomail" || xhr.response.status === "olduser") {
                        j_alert("error", xhr.response.message);
                    }
                    else if (xhr.response.status === "kosql") {
                        j_alert("error", xhr.response.message);
                    }
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>
