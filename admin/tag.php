<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.14
 */
require_once "../lib/start.php";
require_once "../lib/Tag.php";

ini_set('display_errors', 1);

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';
$drawer_label = null;
$exclude = null;
if ($_GET['tid'] == 0) {
	$drawer_label = "Nuova etichetta";
}
else {
	$drawer_label = "Modifica etichetta";
	$exclude = "WHERE tid != ".$_GET['tid'];
	$res = $db->executeQuery("SELECT * FROM rb_tags WHERE tid = ".$_GET['tid']);
	$res_tag = $res->fetch_assoc();
	$tag = new \edocs\Tag($res_tag['tid'], $res_tag['name'], $res_tag['description'], new MySQLDataLoader($db));
}

$res_tags = $db->executeQuery("SELECT * FROM rb_tags $exclude ORDER BY name");

include "tag.html.php";