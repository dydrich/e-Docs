<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>I miei documenti</title>
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
		.mdc-card {
			width: 320px;
			background-color: white;
		}

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
		<div id="container" style="width: 90%; margin: auto; padding: 2%; display: flex; align-items: center; flex-wrap: wrap">
			<div class="info_back_card mdc-elevation--z5">
				<div style="flex: 3; display: flex; align-items: center; " class="bottom_decoration">
					<i class="material-icons accent_color" style="margin-right: 20px; font-size: 4rem"><?php if($row['document_type'] == 1) echo $mime['icon']; else echo 'public' ?></i>
                    <span style="font-size: 2rem"><?php echo $row['title'] ?></span>
				</div>
				<div style="display: block; color: rgba(0, 0, 0, .55); margin-top: 5px"><?php echo $row['abstract'] ?></div>
                <div style="margin-top: 15px">Tipo di file: <?php if($row['document_type'] == 1) echo $mime['tipo']; else echo "link esterno"; ?></div>
                <div style="">Nome: <?php if($row['document_type'] == 1) echo $row['document_name']; else echo 'ND' ?></div>
                <div style="" class="accent_decoration">Dimensioni: <?php if($row['document_type'] == 1) echo human_filesize($fs, 0); else echo 'ND' ?></div>
                <div style="margin-top: 15px">Online dal <?php echo format_date(substr($row['upload_date'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/")." ".substr($row['last_modified_time'], 10, 6) ?></div>
                <div style="">Ultima modifica: <?php echo format_date(substr($row['last_modified_time'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/")." ".substr($row['last_modified_time'], 10, 6) ?></div>
                <div style="" class="accent_decoration">Caricato da: <?php echo $row['author'] ?></div>
                <div style="margin-top: 15px">Tipo di risorsa: <?php echo $row['cat'] ?></div>
                <div style="">Disciplina: <?php echo $row['sub'] ?></div>
                <div style="">Livello scolare: <?php echo $school ?></div>
			</div>
		</div>
	</div>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script></script>
</body>
</html>