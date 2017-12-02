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
$o = 'document_name';
$d = 'asc';
if (isset($_GET['o'])) {
	$o = $_GET['o'];
}
if (isset($_GET['d'])) {
	$d = $_GET['d'];
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
	$name_link = "documents.php?d=desc";
	$arrow = 'arrow_downward';
	if ($d == 'desc') {
		$name_link = "documents.php?d=asc";
		$arrow = 'arrow_upward';
	}
}

try {
	$res_docs = $db->executeQuery("SELECT rb_documents.*, rb_subjects.name as sub FROM rb_documents, rb_subjects WHERE owner = $me AND subject = sid ORDER BY $o $d");
} catch (\edocs\MySQLException $ex) {

}

include "documents.html.php";