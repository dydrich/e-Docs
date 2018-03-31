<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>E-Docs+</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" href="css/general.css">
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
        <div id="menu" style="order: 1">
            <p>Item 1</p>
            <p>Item 2</p>
            <p>Item 3</p>
        </div>
        <div id="content" style="order: 2">
            <h1>Sti cazzissimi</h1>
            <p>
                Tuttavia, va tenuto presente, per meglio comprendere come la teoria geocentrica sia rimasta un atto di fede per secoli e secoli, che il modello della perfetta armonia era la base su cui si muoveva la dottrina portante dell’antica Grecia. Ed è proprio questa visione che portò alla costruzione stupefacente, accurata e geniale di Tolomeo, che riuscì con una complicata geometria a spiegare quasi completamente i fenomeni osservabili, pur basandosi su un’idea di base completamente errata. Egli riuscì a mettere d’accordo la visione spirituale con una complessa ed acuta trattazione scientifica. Ne segue che molte delle grandi intuizioni astronomiche greche che citeremo nel seguito sono spesso singoli episodi “trasgressivi” o rappresentano scoperte scientifiche comunque inseribili nella concezione “ufficiale” generale. Non ci fu mai una vera scuola “alternativa” in grado di sconvolgere le idee di base. Solo dopo Copernico si riuscì a costruire una scuola di pensiero completamente diversa che diede il via ad una scuola di pensiero unificata.
                Sarebbe troppo lungo e complesso citare tutti i grandi pensatori e “matematici” (come venivano chiamati allora, l’astronomia era infatti un branca della matematica) che hanno portato qualche tassello fondamentale (spesso caduto poi nell’oblio) alla comprensione del cielo stellato. Prenderemo in considerazione solo alcuni personaggi, che forse più di altri hanno modificato o chiarito fenomeni prima di allora incompresi. Tra errori ed imprecisioni dovuti spesso alla scarsa tecnologia ed ai limiti degli strumenti di misura, assisteremo a qualcosa di molto simile a veri e propri capolavori “artistici” e non solo scientifici, talmente geniali sono state le intuizioni.
            </p>
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