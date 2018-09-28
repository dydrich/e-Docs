<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Gestione documenti</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
</head>
<body>
<?php include_once "../share/header.php" ?>
<?php include_once "../share/nav.php" ?>
<div id="main">
	<div id="right_col">
		<?php include_once "menu.php" ?>
	</div>
	<div id="left_col">
		<div style="display: flex; flex-wrap: wrap">
			<div id="cards_container" style="display: flex; width: 99%; flex-wrap: wrap; order: 1; justify-content: center">
				<div class="dashboard_card docs_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 2">
					<div class="dashboard_card_body">
						<div class="dashboard_body_left">
							<span style="font-size: 2em;"><?php echo $sub_count ?></span>
							<br /> Aree disciplinari
						</div>
						<div class="dashboard_body_right">
							<i class="material-icons" style="color: #4db6ac; font-size: 3.5em">library_books</i>
						</div>
					</div>
					<div class="dashboard_card_row docs_card_dark">
						<div>
							<a href="subjects.php">
								<span>Gestisci</span>
								<i class="material-icons">forward</i>
							</a>
						</div>
					</div>
				</div>
				<div class="dashboard_card accesses_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 3">
					<div class="dashboard_card_body">
						<div class="dashboard_body_left">
							<span style="font-size: 2em;"><?php echo $cat_count ?></span>
							<br /> Categorie
						</div>
						<div class="dashboard_body_right">
							<i class="material-icons" style="color: #e57373; font-size: 3.5em">style</i>
						</div>
					</div>
					<div class="dashboard_card_row accesses_card_dark">
						<div>
							<a href="categories.php">
								<span>Gestisci</span>
								<i class="material-icons">forward</i>
							</a>
						</div>
					</div>
				</div>
				<div class="dashboard_card downloads_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 4">
					<div class="dashboard_card_body">
						<div class="dashboard_body_left">
							<span style="font-size: 2em;"><?php echo $tag_count ?></span>
							<br /> Tags
						</div>
						<div class="dashboard_body_right">
							<i class="material-icons" style="color: #ce93d8; font-size: 3.5em">label_outline</i>
						</div>
					</div>
					<div class="dashboard_card_row downloads_card_dark">
						<div>
							<a href="tags.php">
								<span>Visualizza</span>
								<i class="material-icons">forward</i>
							</a>
						</div>
					</div>
				</div>
                <div class="dashboard_card channels_card_light mdc-elevation--z3 mdc-elevation-transition" style="order: 5">
                    <div class="dashboard_card_body">
                        <div class="dashboard_body_left">
                            <span style="font-size: 2em;"><?php echo $channels_count ?></span>
                            <br /> Canali
                        </div>
                        <div class="dashboard_body_right">
                            <i class="material-icons" style="color: #7986cb; font-size: 3.5em">cast_connected</i>
                        </div>
                    </div>
                    <div class="dashboard_card_row channels_card_dark">
                        <div>
                            <a href="channels.php">
                                <span>Gestisci</span>
                                <i class="material-icons">forward</i>
                            </a>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script>
    (function() {

    })();
</script>
</body>
</html>