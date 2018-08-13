<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 11/08/18
 * Time: 19.57
 */
require_once "../lib/start.php";
require_once "../lib/MimeType.php";
require_once '../lib/EventLogFactory.php';
require_once "../lib/Document.php";

ini_set("display_errors", 1);

check_session();

$me = $_SESSION['__user__']->getUid();
$school = 'Tutti';
$class = null;
$cls = ['', 'classe prima', 'classe seconda', 'classe terza', 'classe quarta', 'classe quinta', 'classe prima', 'classe seconda', 'classe terza'];

// get file info
$sel_f = "SELECT rb_documents.*, CONCAT_WS(' ', firstname, lastname) as author, rb_categories.name AS cat, rb_subjects.name AS sub 
		  FROM rb_documents, rb_users, rb_categories, rb_subjects 
		  WHERE doc_id = ".$_GET['did']." AND owner = uid AND category = cid AND subject = sid";
try {
	$es_f = $db->executeQuery($sel_f);
	$row = $es_f->fetch_assoc();
	if ($row['school'] != '') {
		$school = strtolower($db->executeCount('SELECT name FROM rb_schools WHERE sid = '.$row['school']));
		if ($row['school_grade'] != '') {
			$school .= ", ".$cls[$row['school_grade']];
		}
	}
} catch (\edocs\MySQLException $e) {

}
$ext = pathinfo($_SESSION['__config__']['document_root']."/".$row['file'], PATHINFO_EXTENSION);
$fs = filesize($_SESSION['__config__']['document_root']."/".$row['file']);
$mime = MimeType::getMimeContentType($_SESSION['__config__']['document_root']."/".$row['file']);

$drawer_label = "Info documento";

include 'doc_info.html.php';