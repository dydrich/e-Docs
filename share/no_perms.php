<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 18/10/17
 * Time: 21.34
 */
include "../lib/start.php";

$drawer_label = "Accesso negato";

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>Errore in archivio</title>
	<link rel="stylesheet" href="../css/general.css" type="text/css" media="screen,projection" />
	<link rel="stylesheet" href="../css/site_themes/<?php echo getTheme() ?>/reg.css" type="text/css" media="screen,projection" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<script type="application/javascript" src="../js/page.js"></script>
	<script type="text/javascript">
        var send_email = function(){
            var url = "bug_notification.php";
            $.ajax({
                type: "POST",
                url: url,
                data: {cls: cls},
                dataType: 'json',
                error: function() {
                    alert("Errore di trasmissione dei dati");
                },
                succes: function() {

                },
                complete: function(data){
                    r = data.responseText;
                    if(r == "null"){
                        return false;
                    }
                    var json = $.parseJSON(r);
                    if (json.status == "kosql"){
                        alert(json.message);
                        console.log(json.dbg_message);
                    }
                    else {
                        j_alert ("alert", "Segnalazione inviata");
                    }
                }
            });
        };
	</script>
</head>
<body>
<?php include "header.php" ?>
<?php include "nav.php" ?>
<div id="main">
	<div id="right_col">
		<?php include_once "../".$_SESSION['area']."/menu.php" ?>
	</div>
	<div id="left_col">
		<div style="width: 75%; margin: auto">
			<h3>
				<i class="material-icons attention">warning</i>
				<span style="position: relative; bottom: 5px">Pagina non consentita</span>
			</h3>
			<div class="mdc-elevation--z5" style="padding: 15px; font-size: 1em">
				<p class="attention" style="font-weight: bold; font-size: 1.2em; padding: 0 0 10px 10px; border-bottom: 1px solid #1E4389;">Accesso negato</p>
				<p class="w_text" style="font-weight: bold">Stai cercando di accedere ad una pagina per la quale non sei stato autorizzato.</p>
				<p class="w_text">Se credi si tratti di un errore, <a href='mailto:<?php echo $_SESSION['__config__']['admin_email'] ?>?subject=Problema di accesso' class="accent_color" style='text-decoration: underline'>contatta l'amministratore.</a></p>
				<div style="width: 100%; margin-top: 20px">
					<a href="<?php echo $referer ?>" class="material_link">Torna indietro</a>
				</div>
			</div>
		</div>
		<p class="spacer"></p>
	</div>
</div>
<?php include "footer.php" ?>
</body>
</html>
