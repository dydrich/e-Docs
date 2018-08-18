<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 15/08/18
 * Time: 20.53
 */
require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";
require_once "lib/DocumentInfo.php";

ini_set('display_errors', 1);

$detect = new Mobile_Detect;
$req = $_REQUEST['req'];
if ($req == 'info') {
	$drawer_label = "Informazioni sul documento";
}
else {
	$drawer_label = "Statistiche sul documento";
}
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
$sel_subjects = "SELECT * FROM rb_subjects ORDER BY name";
try {
	$info = \edocs\DocumentInfo::getInstance($_REQUEST['did'], new MySQLDataLoader($db));
	$res_categorie = $db->executeQuery($sel_categorie);
	$res_subjects = $db->executeQuery($sel_subjects);
} catch (\edocs\MySQLException $e) {

}

include "document_info.html.php";