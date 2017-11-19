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

$drawer_label = "Documenti";
$order = "name ASC";
$mat_icon = 'view_list';
$link = 'documents.php?view=list';
if (isset($_GET['view']) && $_GET['view'] == 'list') {
	$order = "last_modified_time DESC";
	$mat_icon = 'view_module';
	$link = 'documents.php';
}

$res_docs = $db->executeQuery("SELECT rb_documents.*, rb_subjects.name as sub FROM rb_documents, rb_subjects WHERE owner = $me AND subject = sid ORDER BY $order");

include "documents.html.php";