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
        <div style="width: 90%; margin-right: auto; margin-left: auto; margin-top: -10px; text-align: right; display: flex; justify-content: flex-end">
            <?php if(!isset($_GET['view']) || $_GET['view'] != 'list'): ?>
            <div style="width: 60px; color: rgba(0, 0, 0, .57); font-size: 1.2rem; display: flex; align-items: center" class="_bold">
                Nome
            </div>
            <a href="<?php echo $name_link ?>" style="margin-right: 80%">
                <div class="file-action">
                    <i class="material-icons"><?php echo $arrow ?></i>
                </div>
            </a>
            <?php endif; ?>
            <a href="<?php echo $link ?>">
                <div class="file-action">
                    <i class="material-icons"><?php echo $mat_icon ?></i>
                </div>
            </a>
        </div>
        <div style="width: 90%; margin: auto; padding: 2%; display: flex; align-items: center; flex-wrap: wrap">
        <?php
		$index = 0;
        while ($row = $res_docs->fetch_assoc()) {
			$ext = pathinfo($_SESSION['__config__']['document_root']."/".$row['file'], PATHINFO_EXTENSION);
			$fs = filesize($_SESSION['__config__']['document_root']."/".$row['file']);
			$mime = MimeType::getMimeContentType($_SESSION['__config__']['document_root']."/".$row['file']);
			if (!isset($_GET['view']) || $_GET['view'] == 'cards') {
				?>
                <div class="file-card mdc-elevation--z6">
                    <section class="file-title">
                        <h1 class="mdc-card__title mdc-card__title--large"><?php echo $row['title'] ?></h1>
                        <h2 class="mdc-card__subtitle"><?php echo $row['sub'] ?></h2>
                    </section>
                    <section class="file-ext">
                        <div class="mdc-elevation--z1">
							<?php echo strtoupper($ext) ?>
                        </div>
                    </section>
                    <section class="file-bottom">
                        <i class="material-icons"><?php echo $mime['icon'] ?></i>
                        <p style="margin-left: 10px; width: 70%"><?php echo truncateString($row['document_name'], 20) ?></p>
                        <span style=""><?php echo human_filesize($fs, 0) ?></span>
                    </section>
                </div>
				<?php
			}
			else {
			    if ($index == 0) {
					?>
                    <div style="width: 100%; display: flex; flex-wrap: wrap; align-items: center; height: 45px" class="bottom_decoration _bold">
                        <div style="order: 1; flex: 3; display: flex; align-items: center; color: rgba(0, 0, 0, .55)">
                            <a href="documents.php?view=list&o=title&d=desc" style="color: rgba(0, 0, 0, .55)">Titolo</a>
                            <?php if (isset($_GET['view']) && $_GET['view'] == 'list' && $_GET['o'] == 'title'): ?>
                            <a href="documents.php?view=list&o=title&d=<?php echo ($_GET['d'] == 'desc') ? 'asc': 'desc'  ?>" style="margin-right: 80%">
                                <div style="width: 30px; height: 30px;" class="file-action">
                                    <i class="material-icons" style="font-size: 1.2rem"><?php echo $arrow ?></i>
                                </div>
                            </a>
                            <?php endif; ?>
                        </div>
                        <div style="order: 2; flex: 2; display: flex; align-items: center; color: rgba(0, 0, 0, .55)">
                            <a href="documents.php?view=list&o=sub&d=desc" style="color: rgba(0, 0, 0, .55)">Disciplina</a>
							<?php if (isset($_GET['view']) && $_GET['view'] == 'list' && $_GET['o'] == 'sub'): ?>
                                <a href="documents.php?view=list&o=sub&d=<?php echo ($_GET['d'] == 'desc') ? 'asc': 'desc'  ?>" style="margin-right: 20%">
                                    <div style="width: 30px; height: 30px;" class="file-action">
                                        <i class="material-icons" style="font-size: 1.2rem"><?php echo $arrow ?></i>
                                    </div>
                                </a>
							<?php endif; ?>
                        </div>
                        <div style="order: 4; flex: 2; display: flex; align-items: center; color: rgba(0, 0, 0, .55)">
                            <a href="documents.php?view=list&o=last_modified_time&d=desc" style="color: rgba(0, 0, 0, .55)">Ultima modifica</a>
							<?php if (isset($_GET['view']) && $_GET['view'] == 'list' && $_GET['o'] == 'last_modified_time'): ?>
                                <a href="documents.php?view=list&o=last_modified_time&d=<?php echo ($_GET['d'] == 'desc') ? 'asc': 'desc'  ?>" style="margin-right: 20%">
                                    <div style="width: 30px; height: 30px;" class="file-action">
                                        <i class="material-icons" style="font-size: 1.2rem"><?php echo $arrow ?></i>
                                    </div>
                                </a>
							<?php endif; ?>
                        </div>
                        <div style="order: 5; flex: 1; color: rgba(0, 0, 0, .55)">Dimensioni file</div>
                    </div>
					<?php
				}
                    ?>
            <div style="width: 100%; display: flex; flex-wrap: wrap; align-items: center; height: 30px" class="bottom_decoration">
                <div style="order: 1; flex: 3; display: flex; align-items: center">
                    <i class="material-icons accent_color" style="margin-right: 10px; font-size: 1.3rem"><?php echo $mime['icon'] ?></i>
                    <?php echo $row['title'] ?>
                </div>
                <div style="order: 2; flex: 2; color: rgba(0, 0, 0, .55)"><?php echo $row['sub'] ?></div>
                <div style="order: 4; flex: 2; color: rgba(0, 0, 0, .55)"><?php echo format_date(substr($row['last_modified_time'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/")." ".substr($row['last_modified_time'], 10, 6) ?></div>
                <div style="order: 5; flex: 1; color: rgba(0, 0, 0, .55)"><?php echo human_filesize($fs, 0) ?></div>
            </div>
            <?php
                $index++;
            }
        }
        ?>
	</div>
    </div>
    <button id="newdoc" class="mdc-fab material-icons app-fab--absolute" aria-label="Nuovo documento">
        <span class="mdc-fab__icon">
            create
        </span>
    </button>
	<p class="spacer"></p>
</div>
<?php include_once "../share/footer.php" ?>
<script>
    (function() {
        var heightMain = document.getElementById('main').clientHeight;
        var heightScreen = document.body.clientHeight;
        var usedHeight = heightMain > heightScreen ? heightScreen : heightMain;
        var btn = document.getElementById('newdoc');
        btn.style.top = (usedHeight)+"px";
        //btn.style.top = '700px';

        var screenW = screen.width;
        var bodyW = document.body.clientWidth;
        var right_offset = (bodyW - document.getElementById('main').clientWidth) / 2;
        right_offset += document.getElementById('right_col').clientWidth;
        btn.style.right = (right_offset - 18)+"px";

        btn.addEventListener('click', function () {
            window.location = 'doc.php?did=0';
        });
    })();
</script>
</body>
</html>