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
require_once "../lib/DocumentInfo.php";

ini_set("display_errors", 1);

check_session();

$me = $_SESSION['__user__']->getUid();
$school = 'Tutti';
$class = null;
$cls = ['', 'classe prima', 'classe seconda', 'classe terza', 'classe quarta', 'classe quinta', 'classe prima', 'classe seconda', 'classe terza'];

try {
	$info = \edocs\DocumentInfo::getInstance($_REQUEST['did'], new MySQLDataLoader($db));
} catch (\edocs\MySQLException $e) {

}

$drawer_label = "Info documento";

include 'doc_info.html.php';