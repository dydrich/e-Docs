<?php 

require_once "../lib/start.php";

check_session();

$drawer_label = "File non trovato";

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php print $_SESSION['__config__']['intestazione_scuola'] ?>:: file non trovato</title>
    <link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="../css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="../css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="../css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="../css/layouts/small.css">
    <link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="text/javascript" src="../js/page.js"></script>
	<script type="text/javascript">

	</script>
</head>
<body>
<?php include "header.php" ?>
<?php include "nav.php" ?>
<div id="main">
<div id="right_col">
<?php include "../back/menu.php" ?>
</div>
<div id="left_col">
    <div style="width: 75%; margin: auto">
        <h3>
            <i class="material-icons attention">cloud_off</i>
            <span style="position: relative; bottom: 5px">Errore di accesso al documento</span>
        </h3>
        <div class="mdc-elevation--z5" style="padding: 15px; font-size: 1em">
            <p class="attention" style="font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">File non trovato</p>
            <p class="w_text">
                Il file <span class="attention"><?php echo $_SESSION['no_file']['file'] ?></span> da te richiesto non &egrave; presente nel server.<br /><br />
                Il problema &egrave; stato segnalato all'amministratore del sito, e sar&agrave; risolto al pi&ugrave; presto.<br /><br />
                Ti preghiamo di riprovare pi&ugrave; tardi e di scusare il disagio.
            </p>

        </div>
    </div>
</div>
<p class="spacer"></p>
</div>
<?php include "footer.php" ?>
</body>
</html>
