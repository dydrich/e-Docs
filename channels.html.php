<!DOCTYPE html>
<html class="mdc-typography">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>E-Docs+</title>
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<link rel="stylesheet" href="css/general.css">
	<link rel="stylesheet" href="css/site_themes/light_blue/index.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="application/javascript" src="js/page.js"></script>
	<script type="application/javascript">

	</script>
</head>
<body>
<div id="page" class="" style="margin: auto">
	<?php include "header.php" ?>
	<?php include "nav.php" ?>
	<section id="main">
		<div id="menu" style="order: 1; background-color: #f3f5fa">
			<div style="width: 95%; margin: auto; background-color: white; border-radius: 3px; margin-top: 15px">
				<div class="front_item">
					<i class="material-icons" style="margin-right: 10px">watch_later</i>Ultimi inserimenti
				</div>
				<div class="front_item">
					<i class="material-icons" style="margin-right: 10px">highlight</i>In evidenza
				</div>
				<div class="front_item" style="display: flex">
					<i class="material-icons" style="margin-right: 10px; flex: 0 1 10%;">cast</i>
					<span style="flex: 0 1 70%"><a href="channels.php">Canali</a></span>
					<i class="material-icons collapsable" style="flex: 0 1 20%; text-align: center" data-collapse="channels">arrow_drop_down</i>
				</div>
				<div id="channels" style="display: none">
					<?php
					while ($sub = $res_subjects->fetch_assoc()) {
						?>
						<div class="front_item sub_item">
							<a href="channel.php?cid=<?php echo $sub['sid'] ?>"><?php echo $sub['name'] ?></a>
						</div>
						<?php
					}
					?>
				</div>
				<div id="user_space" style="<?php if(!isset($_SESSION['__user__'])) echo 'display: none' ?>">
					<div class="front_item label_item" style="display: flex">
						<i class="material-icons" style="margin-right: 10px; flex: 0 1 10%;">cast_connected</i>
						<span style="flex: 0 1 70%">I tuoi canali</span>
						<i class="material-icons collapsable" style="flex: 0 1 20%; text-align: center"
						   data-collapse="mychannels">arrow_drop_down</i>
					</div>
					<div id="mychannels" style="display: none">
						<div class="front_item sub_item">Storia</div>
						<div class="front_item sub_item">Geografia</div>
					</div>
					<div class="front_item label_item" style="display: flex">
						<i class="material-icons" style="margin-right: 10px; flex: 0 1 10%;">local_library</i>
						<span style="flex: 0 1 70%">La tua libreria</span>
						<i class="material-icons collapsable" style="flex: 0 1 20%; text-align: center"
						   data-collapse="mylibrary">arrow_drop_down</i>
					</div>
					<div id="mylibrary" style="display: none">
						<div class="front_item sub_item">Storia</div>
						<div class="front_item sub_item">Geografia</div>
						<div class="front_item sub_item" style="">Italiano</div>
					</div>
				</div>
			</div>

			<p class="spacer"></p>
		</div>
		<div id="content" style="order: 2">
			<div class="main_front_label">
				<p>
					<i class="material-icons">cast</i>
					<span>Canali</span>
				</p>
			</div>
			<?php
			$res_subjects->data_seek(0);
			while ($sub = $res_subjects->fetch_assoc()) {
				$sql = "SELECT rb_documents.*, rb_categories.name AS cat, rb_categories.color AS color, rb_categories.icon AS icon, rb_subjects.name as sub 
		FROM rb_documents, rb_subjects, rb_categories 
		WHERE subject = sid AND sid = ".$sub['sid']."
		AND category = cid
		ORDER BY upload_date DESC LIMIT 6";
				$docs_sub = $db->executeQuery($sql);
				?>
				<div class="front_label">
					<p><?php echo $sub['name'] ?></p>
				</div>
				<div style="display: flex; padding-left: 40px">
					<?php
					while ($r = $docs_sub->fetch_assoc()) {
						?>
						<div class="file-card mdc-elevation--z2" id="sbitem<?php echo $r['doc_id'] ?>" data-id="<?php echo $r['doc_id'] ?>" data-list="subjects">
							<section class="file-subject normal">
								<p style="margin: auto"><?php echo $r['cat'] ?></p>
							</section>
							<section class="file-ext">
								<div>
									<i class="material-icons" style="font-size: 7rem; color: #4FC3F7"><?php echo $r['icon'] ?></i>
								</div>
							</section>
							<section class="file-title normal">
								<h1 class=""><?php echo truncateString($r['title'], 25) ?></h1>
								<!--<h2 class="mdc-card__subtitle"><?php echo $r['sub'] ?></h2>-->
							</section>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>

			<p class="spacer"></p>
			<p class="spacer"></p>
		</div>
	</section>
</div>
<?php include "footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));

    var selected_doc = 0;
    var selected_list = 'highlight';

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('open_drawer').addEventListener('click', function () {
            toggle_fixed_drawer();
        }, false);

        document.getElementById('login_button').addEventListener('click', function (event) {
            submit_login(event);
        }, false);

        document.getElementById('signup_button').addEventListener('click', function (event) {
            signup(event);
        }, false);

        document.getElementById('req_button').addEventListener('click', function (event) {
            request_password(event);
        }, false);

        document.getElementById('closereq').addEventListener('click', function (event) {
            show_sign_menu(event, 'reqpwd', 320);
        }, false);

        document.getElementById('newpwd').addEventListener('click', function (event) {
            fade('login', 'out', 200, 0);
            show_sign_menu(event, 'reqpwd', 320);
        }, false);
        document.getElementById('content').addEventListener('contextmenu', function (ev) {
            ev.preventDefault();
            clear_context_menu(ev, 'doc_context_menu');
            if (selected_doc !== 0) {
                if (selected_list === 'highlight') {
                    document.getElementById('item'+selected_doc).classList.remove('selected_doc');
                }
                else {
                    document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
                }
            }
            return false;
        });
        document.getElementById('content').addEventListener('click', function (ev) {
            ev.preventDefault();
            clear_context_menu(ev, 'doc_context_menu');
            if (selected_doc !== 0) {
                if (selected_list === 'highlight') {
                    document.getElementById('item'+selected_doc).classList.remove('selected_doc');
                }
                else {
                    document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
                }
            }
            return false;
        });
        document.getElementById('show_doc').addEventListener('click', function (ev) {
            clear_context_menu(ev, 'doc_context_menu');
            getFileName(selected_doc, 'open_in_browser');
        });
        document.getElementById('down_doc').addEventListener('click', function (ev) {
            clear_context_menu(ev, 'doc_context_menu');
            if (selected_list === 'highlight') {
                document.getElementById('item'+selected_doc).classList.remove('selected_doc');
            }
            else {
                document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
            }
            document.location.href = 'share/download_manager.php?register=1&did='+selected_doc;
        });
        var ends = document.querySelectorAll('.file-card');
        for (i = 0; i < ends.length; i++) {
            ends[i].addEventListener('click', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                clear_context_menu(event, 'doc_context_menu');
                if (selected_doc !== 0) {
                    if (selected_list === 'highlight') {
                        document.getElementById('item'+selected_doc).classList.remove('selected_doc');
                    }
                    else {
                        document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
                    }
                }
                event.currentTarget.classList.add('selected_doc');
                selected_doc = event.currentTarget.getAttribute("data-id");
                selected_list = event.currentTarget.getAttribute("data-list");
            });
            ends[i].addEventListener('contextmenu', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                if (selected_doc !== 0) {
                    if (selected_list === 'highlight') {
                        document.getElementById('item'+selected_doc).classList.remove('selected_doc');
                    }
                    else {
                        document.getElementById('sbitem'+selected_doc).classList.remove('selected_doc');
                    }
                }
                event.currentTarget.classList.add('selected_doc');
                current_target_id = event.currentTarget.getAttribute("data-id");
                current_target_list = event.currentTarget.getAttribute("data-list");
                //clear_context_menu(event);
                show_context_menu(event, null, 0, 'doc_context_menu');
                selected_doc = event.currentTarget.getAttribute("data-id");
                selected_list = current_target_list;
            });
        }

        var open_in_browser = function () {
            //document.location.href = 'doc.php?did='+selected_doc+'&back=documents.php';
        };

        var collapsables = document.querySelectorAll('.collapsable');
        for (i = 0; i < collapsables.length; i++) {
            collapsables[i].addEventListener('click', function (event) {
                var element = document.getElementById(event.currentTarget.getAttribute("data-collapse"));
                if (element.style.display !== 'block') {
                    element.style.opacity = 0;
                    element.style.display = 'block';
                    fade(event.currentTarget.getAttribute("data-collapse"), 'in', 400, 1);
                    event.currentTarget.innerText = 'arrow_drop_up';
                }
                else {
                    element.style.display = 'none';
                    event.currentTarget.innerText = 'arrow_drop_down';
                }

                //element.style.display = 'block';
            });
        }
    });

    var submit_login = function (ev) {
        ev.preventDefault();
        var xhr = new XMLHttpRequest();
        var formElement = document.getElementById('signinform');
        var formData = new FormData(formElement);

        xhr.open('post', 'do_login.php');
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.response.status !== 'ok') {
                    alert(xhr.response.status);
                    j_alert("error", xhr.response.message);
                    return false;
                }
                if (xhr.status === OK) {
                    if (xhr.response.role == 3) {
                        document.location.href = 'admin/index.php';
                    }
                    var div = document.getElementById('sc_secondrow');
                    div.innerHTML = '<i class="material-icons" style="position: relative; top: 1px">person</i>\n' +
                        '<span style="position: relative; margin-left: 5px; bottom: 5px">\n' +
                        '                <a href="#" onclick="show_user_menu(event, \'access_menu\', 200)">\n' + xhr.response.name +
                        '                    <i id="arrow" class="material-icons" style="position: relative; top: 8px">arrow_drop_down</i>\n' +
                        '                </a>\n' +
                        '            </span>\n';
                    fade('login', 'out', 500, 0);
                    document.getElementById('user_space').style.display = 'block';
                }
            }
        }
    };

    var request_password = function(){
        var mail = document.getElementById('my-email').value;

        var url = "password_manager.php";

        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'password_manager.php');
        var action = 'sendmail';

        formData.append('email', mail);
        formData.append('action', action);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    if (xhr.response.status === 'ok') {
                        j_alert('alert', xhr.response.message);
                    }
                    else if (xhr.response.status === "nomail" || xhr.response.status === "olduser") {
                        j_alert("error", xhr.response.message);
                    }
                    else if (xhr.response.status === "kosql") {
                        j_alert("error", xhr.response.message);
                    }
                    fade('reqpwd', 'out', 200, 0);
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>