<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione categorie</title>
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
		.app-fab--absolute.app-fab--absolute {
			position: fixed;
			/*right: 39rem;*/
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
		<div style="width: 90%; margin: auto;">
			<div class="mdc-list mdc-list" style="display: flex; flex-wrap: wrap; justify-content: left; margin: auto">
				<?php
				while ($row = $res_cats->fetch_assoc()) {
					?>
					<a href="category.php?cid=<?php echo $row['cid'] ?>&back=categories.php" data-id="<?php echo $row['cid'] ?>" id="item<?php echo $row['cid'] ?>"  class="mdc-list-item mdc-elevation--z3" data-mdc-auto-init="MDCRipple">
						<span class="mdc-list-item__start-detail _bold" role="presentation">
							<i class="material-icons">style</i>
						</span>
						<span class="mdc-list-item__text">
						  <?php echo $row['name'] ?>
						</span>
                        <span class="mdc-list-item__end-detail material-icons accent_color" style="display: none; font-size: 1rem; position: relative; right: -7px; top: -7px">
                            delete
                        </span>
					</a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<button id="newsubject" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuova categoria">
        <span class="mdc-fab__icon">
            create
        </span>
	</button>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var heightMain = document.getElementById('main').clientHeight;
        var heightScreen = document.body.clientHeight;
        var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;
        var btn = document.getElementById('newsubject');
        btn.style.top = (usedHeight)+"px";
        //btn.style.top = '700px';

        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - document.getElementById('main').clientWidth) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
        btn.style.right = (right_offset - 18)+"px";

        btn.addEventListener('click', function () {
            window.location = 'category.php?cid=0&back=categories.php';
        });

        var ends = document.querySelectorAll('.mdc-list-item');
        for (i = 0; i < ends.length; i++) {
            ends[i].addEventListener('mouseenter', function (event) {
                event.target.getElementsByTagName('span')[2].style.display = 'inline';
            });
            ends[i].addEventListener('mouseleave', function (event) {
                event.target.getElementsByTagName('span')[2].style.display = 'none';
            });
        }
        var deletes = document.querySelectorAll('.mdc-list-item__end-detail');
        for (i = 0; i < deletes.length; i++) {
            deletes[i].addEventListener('click', function (event) {
                event.preventDefault();
                var parent = event.target.parentElement;
                itemID = parent.dataset.id;
                delete_item(itemID);
            });
        }
    });

    var delete_item = function (itemID) {
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'category_manager.php');
        var action = <?php echo ACTION_DELETE ?>;

        formData.append('cid', itemID);
        formData.append('action', action);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    j_alert("alert", xhr.response.message);
                    var item_to_del = document.getElementById('item'+itemID);
                    item_to_del.style.display = 'none';
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };
</script>
</body>
</html>