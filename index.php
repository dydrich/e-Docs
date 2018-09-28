<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 19/10/17
 * Time: 6.48
 */

require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Mobile_Detect.php";

ini_set('display_errors', 1);

$drawer_label = "Home";
$detect = new Mobile_Detect;

$sel_channel = 'SELECT * FROM rb_channels WHERE idc = '.$_REQUEST['idc'];

$sql = "SELECT rb_documents.*, rb_categories.color AS color, rb_categories.icon AS icon, rb_subjects.name as sub 
		FROM rb_documents, rb_subjects, rb_categories 
		WHERE subject = sid 
		AND category = cid
		ORDER BY upload_date DESC LIMIT 16";
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
$sel_channels = "SELECT * FROM rb_channels WHERE level < 2 ORDER BY level, name";
try {
	$res_docs = $db->executeQuery($sql);
	$res_categorie = $db->executeQuery($sel_categorie);
	$res_channels = $db->executeQuery($sel_channels);

} catch (\edocs\MySQLException $ex) {

}

include "index-html.php";