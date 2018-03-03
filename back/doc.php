<?php
ini_set("display_errors", 1);
require_once "../lib/start.php";
require_once "../lib/MimeType.php";
require_once '../lib/EventLogFactory.php';
require_once "../lib/RBUtilities.php";
require_once "../lib/Document.php";



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
	try {
		$r_doc = $db->executeQuery($sel_doc);
	} catch (\edocs\MySQLException $ex) {

	}

	$current_doc = $r_doc->fetch_assoc();

	$sel_tags = "SELECT name FROM rb_tags, rb_doc_tag WHERE rb_tags.tid = rb_doc_tag.tid AND doc_id = {$did}";
	try {
		$res_tags = $db->executeQuery($sel_tags);
	} catch (\edocs\MySQLException $ex) {

	}

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
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
$sel_ordini = "SELECT * FROM rb_schools ORDER BY name";
$sel_grades = "SELECT * FROM rb_grades ORDER BY grade ASC";
try {
	$res_materie = $db->executeQuery($sel_materie);
	$res_categorie = $db->executeQuery($sel_categorie);
	$res_ordini = $db->executeQuery($sel_ordini);
	$res_grades = $db->executeQuery($sel_grades);
	$schema_db = new MySQLConnection("localhost", "root", "isildur", "information_schema", "3306");
	$nv = $schema_db->executeCount("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'edocs' AND TABLE_NAME = 'rb_documents'");
} catch (\edocs\MySQLException $ex) {

}

include "doc.html.php";
