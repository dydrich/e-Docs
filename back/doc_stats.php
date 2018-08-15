<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 14/08/18
 * Time: 12.06
 */
require_once "../lib/start.php";
require_once "../lib/MimeType.php";
require_once "../lib/DocumentInfo.php";

ini_set('display_errors', 1);

check_session();

$me = $_SESSION['__user__']->getUid();
$doc_id = $_REQUEST['did'];

try {
	$info = \edocs\DocumentInfo::getInstance($_REQUEST['did'], new MySQLDataLoader($db));
} catch (\edocs\MySQLException $ex) {

}

$drawer_label = "Statistiche documento";

include "doc_stats.html.php";
