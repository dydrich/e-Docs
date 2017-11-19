<?php

require_once "../lib/start.php";
require_once "../lib/MimeType.php";
require_once '../lib/EventLogFactory.php';
require_once "../lib/ArrayMultiSort.php";
require_once "../lib/RBUtilities.php";
require_once "../lib/Document.php";

ini_set("display_errors", 1);

check_session();

// per la paginazione del REFERER
if (isset($_SERVER['HTTP_REFERER'])){
	$referer = $_SERVER['HTTP_REFERER'];
}
else {
	$referer = $_SERVER['PHP_SELF'];
}

if(isset($_REQUEST['did']) && $_REQUEST['did'] != 0){
	$did = $_REQUEST['did'];
	$sel_doc = "SELECT * FROM rb_documents WHERE doc_id = ".$_REQUEST['did'];
	$r_doc = $db->executeQuery($sel_doc);
	$current_doc = $r_doc->fetch_assoc();

	$sel_tags = "SELECT name FROM rb_tags, rb_doc_tag WHERE rb_tags.tid = rb_doc_tag.tid AND doc_id = {$did}";
	$res_tags = $db->executeQuery($sel_tags);
	$tags = array();
	if ($res_tags->num_rows > 0){
		while ($rt = $res_tags->fetch_assoc()){
			$tags[] = $rt['tag'];
		}
	}
}
else{
	$did = 0;
	$current_doc = null;
	$tipo = null;
}

$drawer_label = "Gestione documento";

$sel_materie = "SELECT * FROM rb_subjects ORDER BY name";
$res_materie = $db->executeQuery($sel_materie);
	
// categorie
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
$res_categorie = $db->executeQuery($sel_categorie);
	
// ordini di scuola
$sel_ordini = "SELECT * FROM rb_schools ORDER BY name";
$res_ordini = $db->executeQuery($sel_ordini);
	
/*
 * grades
 */

$sel_grades = "SELECT * FROM rb_grades ORDER BY grade ASC";
$res_grades = $db->executeQuery($sel_grades);

$nv = $db->executeCount("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'edocs' AND TABLE_NAME = 'documents'");
echo "==>".$nv;

include "doc.html.php";
