<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dettaglio documento</title>
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
        .mdc-text-field, .mdc-select {
            width: 90%;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php include "../share/header.php" ?>
<?php include "../share/nav.php" ?>
<div id="main">
<div id="right_col">
<?php include "menu.php" ?>
</div>
<div id="left_col">
    <div style="width: 90%; margin: auto">
        <form method="post" id="docform"  class="mdc-elevation--z5" style="width: 90%; text-align: center; margin: auto; padding: 10px" onsubmit="go(event)">
            <div class="mdc-text-field" data-mdc-auto-init="MDCTextField">
                <input type="text" required id="title" name="title" class="mdc-text-field__input" value="<?php if(isset($document)) echo $document->getTitle() ?>">
                <label class="mdc-floating-label" for="title">Titolo</label>
            </div>
            <div class="mdc-text-field mdc-text-field--textarea" style="margin-right: auto; margin-left: auto" data-mdc-auto-init="MDCTextField">
                <textarea required id="abstract" name="abstract" class="mdc-text-field__input" rows="8" cols="40"><?php if(isset($document)) echo $document->getAbstract() ?></textarea>
                <label for="abstract" class="mdc-floating-label">Abstract</label>
            </div>
            <select required class="mdc-select form_input" name="subject" id="subject">
                <option value="" selected>Disciplina</option>
				<?php
				while ($row = $res_materie->fetch_assoc()) {
					?>
                    <option value="<?php echo $row['sid'] ?>" <?php if(isset($document) && $document->getSubject() == $row['sid']) echo "selected" ?>><?php echo $row['name'] ?></option>
					<?php
				}
				?>
            </select>
            <select required class="mdc-select form_input" name="type" id="type">
                <option value="" <?php if(!isset($document)) echo "selected" ?>>Tipo di risorsa</option>
				<option value="1" <?php if(isset($document) && $document->getDocumentType() == 1) echo "selected" ?>>File</option>
				<option value="2" <?php if(isset($document) && $document->getDocumentType() == 2) echo "selected" ?>>Risorsa esterna</option>
            </select>
            <select required class="mdc-select form_input" name="category" id="category" style="">
                <option value="" selected>Categoria</option>
				<?php
				while ($row = $res_categorie->fetch_assoc()) {
					?>
                    <option value="<?php echo $row['cid'] ?>" <?php if(isset($document) && $document->getCategory() == $row['cid']) echo "selected" ?>><?php echo $row['name'] ?></option>
					<?php
				}
				?>
            </select>
            <div id="if_container" style="width: 90%; margin: auto">
                <p style="text-align: left; color: rgba(0, 0, 0, .5">File</p>
                <?php if(isset($current_doc)){ ?>
                    <input class="form_input" type="text" name="fname" id="fname" style="width: 75%" readonly value="<?php echo $document->getFile() ?>"/>
                    <a href="#" onclick="load_iframe('')" style="margin-left: 15px" class="material_link">Modifica file</a>
                <?php }  else{ ?>
                    <div id="iframe">
                        <iframe src="upload_manager.php" style="border: 0; width: 100%" id="aframe"></iframe>
                    </div>
                    <a href="#" onclick="del_file()" id="del_upl" style="">Annulla upload</a>
                <?php } ?>
            </div>
            <div class="mdc-text-field" data-mdc-auto-init="MDCTextField" id="lnk_field" style="display: none; margin: auto;">
                <input type="text" id="link" name="link" class="mdc-text-field__input" value="">
                <label class="mdc-floating-label" for="link">Link</label>
            </div>
            <div class="mdc-text-field" data-mdc-auto-init="MDCTextField">
                <input type="text" name="tag" id="tag" style="width: 80%" list="tag_list" class="mdc-text-field__input" />
                <label class="mdc-floating-label" for="title">Tag</label>
                <datalist id="tag_list"></datalist>
                <a href="#" id="add_tag" style="margin-left: 20px; margin-bottom: 8px" onclick="addTag(event)" class="material_link">Aggiungi</a>
            </div>
            <div id="tags_ct" style="width: 90%; margin: auto; display: block; text-align: left">
				<?php
				if (isset($tags)){
					reset($tags);
					$i = 0;
					foreach ($tags as $t){
						?>
                        <p id='tag_<?php echo $i ?>' style='height: 16px; margin: 3px 0 0 0'>
                            <a href='#' onclick='deleteTag(<?php echo $i ?>)' style='margin-right: 5px'>
                                <i class='material-icons' style='font-size: 1rem; color: rgba(0, 0, 0, .5)'>cancel</i>
                            </a>
                            <span style='position: relative; top: -2px'><?php echo $t ?></span>
                        </p>
						<?php
                        $i++;
					}
				}
				?>
            </div>
            <select required class="mdc-select form_input" name="school" id="school">
                <option value="" selected>Ordine di scuola</option>
				<?php
				while ($row = $res_ordini->fetch_assoc()) {
					?>
                    <option value="<?php echo $row['sid'] ?>" <?php if(isset($document) && $document->getSchool() == $row['sid']) echo "selected" ?>><?php echo $row['name'] ?></option>
					<?php
				}
				?>
            </select>
            <select required class="mdc-select form_input" name="grade" id="grade">
                <option value="" selected>Classe</option>
				<?php
				while ($row = $res_grades->fetch_assoc()) {
					?>
                    <option value="<?php echo $row['grade'] ?>" <?php if(isset($document) && $document->getSchoolGrade() == $row['grade']) echo "selected" ?>><?php echo $row['description'] ?></option>
					<?php
				}
				?>
            </select>
            <input type="hidden" id="server_file" name="server_file" />
            <input type="hidden" id="doc_name" name="doc_name" />
            <input type="hidden" id="did" name="did" value="<?php echo $did ?>" />
            <section class="mdc-card__actions" style="margin-left: 3%; margin-top: 20px">
                <button id="submit_btn" onclick="go(event)" class="mdc-button mdc-button--compact mdc-card__action">Registra</button>
            </section>
        </form>
</div>
<p class="spacer"></p>
</div>
</div>
<?php include "../share/footer.php" ?>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    window.mdc.autoInit();
    mdc.textField.MDCTextField.attachTo(document.querySelector('.mdc-text-field'));

    function supportFormData() {
        return !! window.FormData;
    }

    var del_file = function (event) {
        event.preventDefault();
        if (!supportFormData()) {
            alert("Not supported :(");
        }
        var xhr = new XMLHttpRequest();
        var formData = new FormData();

        xhr.open('post', 'document_manager.php');
        var action = <?php echo \edocs\Document::$QUICK_DELETE ?>;

        formData.append('server_file', document.getElementById('server_file').value);
        formData.append('action', action);
        xhr.responseType = 'json';
        xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    j_alert("alert", xhr.response.message);
                    reload_iframe();
                    document.getElementById('server_file').value = "";
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

    var reload_iframe = function(){
        document.getElementById('aframe').setAttribute('src', 'upload_manager.php');
    };

    var load_iframe = function(file){
        document.getElementById('server_file').value = '';
        document.getElementById('if_container').innerHTML = '<div id="iframe"><iframe src="upload_manager.php" id="aframe"></iframe></div>';
    };

    var loading = function(vara){
        background_process("Stiamo caricando il file", vara, false);
    };

    var loading_done = function(r){
        document.getElementById('server_file').value = r;
        loaded("Il file è stato caricato");
    };

    tid = <?php if (isset($tags)) echo count($tags); else echo "0" ?>;
    _tags = [];
	<?php
	$i = 0;
	if (isset($tags)){
        foreach ($tags as $t){
        ?>
        _tags[<?php echo $i ?>] = '<?php echo $t ?>';
        <?php
            $i++;
        }
	}
	?>

    var addTag = function(event){
        event.preventDefault();
        tag = document.getElementById('tag').value;
        new_p = document.createElement('p');
        new_p.setAttribute('id', 'tag_'+tid);
        new_p.style.height = '16px';
        new_p.style.margin = '3px 0 0 0';
        new_p.innerHTML = "<a href='#' onclick='event.preventDefault(); deleteTag("+tid+")' style='margin-right: 5px'><i class='material-icons' style='font-size: 1rem; color: rgba(0, 0, 0, .5)'>cancel</i></a><span style='position: relative; top: -2px'>"+tag+"</span>";
        document.getElementById('tags_ct').appendChild(new_p);
        document.getElementById('tag').value = '';
        document.getElementById('tag').focus();
        _tags[tid] = tag;
        tid++;
        return false;
    };

    var deleteTag = function(tag){
        document.getElementById('tag_'+tag).style.display = 'none';
        _tags.splice(tag, 1);
    };

    var go = function go(event){
        event.preventDefault();

        /*
        validate form
         */
        if (!validate_form()) {
            j_alert('error', 'I campi Titolo, Abstract, Disciplina, Tipo e File sono obbligatori');
            return false;
        }

        var __tags = _tags.join(",");

        var xhr = new XMLHttpRequest();
        var formData = new FormData(document.getElementById('docform'));

        xhr.open('post', 'document_manager.php');
        var action = <?php if ($_REQUEST['did'] != 0) echo \edocs\Document::$UPDATE_DOCUMENT; else echo \edocs\Document::$INSERT_DOCUMENT ?>;

        formData.append('action', action);
        formData.append('tags', __tags);
        xhr.responseType = 'json';

       xhr.send(formData);
        xhr.onreadystatechange = function () {
            var DONE = 4; // readyState 4 means the request is done.
            var OK = 200; // status 200 is a successful return.
            if (xhr.readyState === DONE) {
                if (xhr.status === OK) {
                    json = xhr.response;
                    if (xhr.response.status === "kosql"){
                        j_alert("error", json.message);
                        console.log(json.dbg_message);
                    }
                    else if (json.status === "ko") {
                        j_alert("error", json.message);
                        console.log(json.dbg_message);
                    }
                    else {
                        j_alert("alert", json.message);
                        window.setTimeout(function(){
                            document.location.href = "documents.php";
                        }, 3000);
                    }
                }
            } else {
                console.log('Error: ' + xhr.status);
            }
        }
    };

    window.addEventListener("load", function(){
        // Add a keyup event listener to our input element
        var name_input = document.getElementById('tag');
        name_input.addEventListener("keyup", function(event){hinter(event)});

        // create one global XHR object
        // so we can abort old requests when a new one is make
        window.hinterXHR = new XMLHttpRequest();

        document.getElementById('type').addEventListener('change', function (event) {
            if (this.value != 2) {
                document.getElementById('if_container').style.display = 'block';
                document.getElementById('lnk_field').style.display = 'none';
            }
            else {
                document.getElementById('if_container').style.display = 'none';
                document.getElementById('lnk_field').style.display = 'inline-flex';
            }
        });
    });

    var hinter = function(event) {

        // retrieve the input element
        var input = event.target;

        // retrieve the datalist element
        var huge_list = document.getElementById('tag_list');

        // minimum number of characters before we start to generate suggestions
        var min_characters = 1;

        if (input.value.length < min_characters ) {
            return false;
        } else {

            // abort any pending requests
            window.hinterXHR.abort();
            window.hinterXHR.responseType = 'json';

            window.hinterXHR.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {

                    // clear any previously loaded options in the datalist
                    tag_list.innerHTML = "";

                    response = window.hinterXHR.response;

                    response.forEach(function(item) {
                        // Create a new <option> element.
                        var option = document.createElement('option');
                        option.value = item.value;
                        option.innerText = item.value;

                        // attach the option to the datalist element
                        tag_list.appendChild(option);
                    });
                }
            };

            window.hinterXHR.open("GET", "get_tags.php?term=" + input.value, true);
            window.hinterXHR.send()
        }
    };

    var validate_form = function () {

        if(document.getElementById('title').value === ""){
            return false;
        }

        if(document.getElementById('abstract').value === ""){
            return false;
        }

        if(document.getElementById('server_file').value === "" && document.getElementById('type') === "1"){
            return false;
        }

        if(document.getElementById('subject').value === ""){
            return false;
        }

        if(document.getElementById('type').value === ""){
            return false;
        }

        return true;
    };

</script>
</body>
</html>
