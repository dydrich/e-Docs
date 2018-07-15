<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>E-Docs+</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/site_themes/light_blue/index.css">
    <link rel="stylesheet" media="screen and (min-width: 2000px)" href="css/layouts/index/larger.css">
    <link rel="stylesheet" media="screen and (max-width: 1999px) and (min-width: 1300px)" href="css/layouts/index/wide.css">
    <link rel="stylesheet" media="screen and (max-width: 1299px) and (min-width: 640px)" href="css/layouts/index/normal.css">
    <link rel="stylesheet" media="screen and (max-width: 639px)" href="css/layouts/index/small.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="application/javascript" src="js/page.js"></script>
</head>
<body>
<div id="page" class="" style="margin: auto">
    <?php include "header.php" ?>
    <?php include "nav.php" ?>
    <section id="main">
        <div id="menu" style="order: 1">
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
                        <a href="channel.php?cid=<?php echo $sub['sid'] ?>"><?php echo $sub['name'] ?></a></div>
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
            <?php if(!$detect->isMobile()): ?>
            <p class="spacer"></p>
            <?php endif; ?>
        </div>
        <div id="content" style="order: 2">
            <div class="main_front_label">
                <p>
                    <i class="material-icons">watch_later</i>
                    <span id="screenlab">Ultimi inserimenti</span>
                </p>
            </div>
            <div style="display: flex; padding-left: 40px; margin-top: 20px; flex-wrap: wrap">
                <?php
                while ($row = $res_docs->fetch_assoc()) {
					?>
                    <div class="file-card" id="item<?php echo $row['doc_id'] ?>" data-id="<?php echo $row['doc_id'] ?>" data-list="highlight">
                        <section class="file-subject normal">
                            <p style="margin: auto"><?php echo $row['sub'] ?></p>
                        </section>
                        <section class="file-ext">
                            <div>
                                <i class="material-icons" style="font-size: 7rem; color: #4FC3F7"><?php echo $row['icon'] ?></i>
                            </div>
                        </section>
                        <section class="file-title normal">
                            <h1 class=""><?php echo truncateString($row['title'], 25) ?></h1>
                            <!--<h2 class="mdc-card__subtitle"><?php echo $row['sub'] ?></h2>-->
                        </section>
                    </div>
					<?php
				}
                ?>
            </div>

            <p class="spacer"></p>
            <p class="spacer"></p>
        </div>
    </section>
</div>
<?php include "footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="front.js" type="application/javascript"></script>
<script type="application/javascript">
    var is_mobile = <?php if ($detect->isMobile()) echo 1; else echo 0; ?>;
    (function() {
        var w = window.screen.width ;
        var h = window.screen.height;
        document.getElementById('screenlab').innerText += " "+w+"x"+h;
    })();
</script>
</body>
</html>