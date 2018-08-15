<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 17.44
 */
require_once "../lib/start.php";
require_once "../lib/MimeType.php";
require_once '../lib/EventLogFactory.php';
require_once "../lib/Document.php";

ini_set("display_errors", 1);

check_session();

$me = $_SESSION['__user__']->getUid();

/*
 * order
 */
$o = 'title';
$d = 'asc';
$label = 'Nome';
if (isset($_GET['o'])) {
	$o = $_GET['o'];
}
if (isset($_GET['d'])) {
	$d = $_GET['d'];
}

switch ($o) {
	case 'title':
		$label = 'Nome';
		break;
	case 'category':
		$label = 'Categoria';
		break;
	case "subject":
		$label = 'Disciplina';
		break;
	case 'upload_date':
		$label = 'Data caricamento';
		break;
	case "last_modified_time":
		$label = 'Ultima modifica';
		break;
}

$drawer_label = "Documenti";
$mat_icon = 'view_list';
$link = 'documents.php?view=list&o=last_modified_time&d=desc';
$arrow = "arrow_upward";
if (isset($_GET['d']) && $_GET['d'] == 'asc') {
	$arrow = 'arrow_downward';
}
if (isset($_GET['view']) && $_GET['view'] == 'list') {
	$mat_icon = 'view_module';
	$link = 'documents.php';
}
else {
	/*
	 * order link
	 */
	$name_link = "documents.php?o=".$o."&d=desc";
	$arrow = 'arrow_downward';
	if ($d == 'desc') {
		$name_link = "documents.php?o=".$o."&d=asc";
		$arrow = 'arrow_upward';
	}
}
$sql = "SELECT rb_documents.*, rb_categories.color AS color, rb_categories.icon AS icon, rb_subjects.name as sub 
		FROM rb_documents, rb_subjects, rb_categories 
		WHERE owner = $me 
		AND subject = sid 
		AND category = cid
		ORDER BY $o $d";
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
try {
	$res_docs = $db->executeQuery($sql);
	$res_categorie = $db->executeQuery($sel_categorie);
} catch (\edocs\MySQLException $ex) {

}

$cat_menu_h = $res_categorie->num_rows * 50;

include "documents.html.php";