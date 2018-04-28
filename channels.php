<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 28/04/18
 * Time: 19.17
 */

require_once "lib/start.php";
require_once "lib/load_env.php";

$drawer_label = "Home";

$sql = "SELECT rb_documents.*, rb_categories.color AS color, rb_categories.icon AS icon, rb_subjects.name as sub 
		FROM rb_documents, rb_subjects, rb_categories 
		WHERE subject = sid 
		AND category = cid
		ORDER BY upload_date DESC LIMIT 6";
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
$sel_subjects = "SELECT * FROM rb_subjects ORDER BY name";
try {
	$res_docs = $db->executeQuery($sql);
	$res_categorie = $db->executeQuery($sel_categorie);
	$res_subjects = $db->executeQuery($sel_subjects);

} catch (\edocs\MySQLException $ex) {

}

include "channels.html.php";