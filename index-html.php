<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>E-Docs+</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="css/layouts/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="css/layouts/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 1025px)" href="css/layouts/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 1024px)" href="css/layouts/small.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="application/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('public').addEventListener('click', function () {
                document.location.href = 'front/index.html';
            }, false);

            document.getElementById('private').addEventListener('click', function () {
                document.location.href = 'login.php?area=private';
            }, false);

            document.getElementById('admin').addEventListener('click', function () {
                document.location.href = 'login.php?area=admin';
            }, false);
        });
    </script>
</head>
<body>
<header>
    <div class="wrap">
        <div style="" id="_header">
            <h1 class="mdc-typography--display1"><?php echo $_SESSION['__config__']['software_name']." ".$_SESSION['__config__']['software_version'] ?></h1>
            <p id="sw_version" style="">
                Software di condivisione e archiviazione materiali didattici
            </p>
        </div>
    </div>
</header>
<section class="wrap">
    <div id="login_form" style="display: flex; display: -webkit-flex; flex-direction: row; flex-wrap: wrap; align-items: center;">
        <div class="area">
            <a href="#" id="admin">
                <i class="material-icons" style="color: #673ab7">build</i>
                <div style="">Amministrazione</div>
            </a>
        </div>
        <div class="area" id="center_el">
            <a href="#" id="private">
                <i class="material-icons" style="color: #880e4f">cloud_upload</i>
                <div style="">Area privata</div>
            </a>
        </div>
        <div class="area" id="area_school">
            <a href="#" id="public">
                <i class="material-icons" style="color: #00bfa5">public</i>
                <div style="">Area pubblica</div>
            </a>
        </div>
        <footer id="footer" style="margin-right: 20px">
            <span>Copyright <?php echo date("Y") ?> Riccardo Bachis </span>
        </footer>
    </div>
</section>
</body>
</html>