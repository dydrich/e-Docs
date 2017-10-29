<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 24/10/17
 * Time: 7.16
 */
require_once "../lib/start.php";
require_once "../lib/Category.php";

ini_set('display_errors', 1);

check_session();
check_role(User::$ADMIN);

$_SESSION['area'] = 'admin';
$drawer_label = null;
$exclude = null;
if ($_GET['cid'] == 0) {
	$drawer_label = "Nuova categoria";
}
else {
	$drawer_label = "Modifica categoria";
	$exclude = "WHERE cid != ".$_GET['cid'];
	$res = $db->executeQuery("SELECT * FROM rb_categories WHERE cid = ".$_GET['cid']);
	$res_cat = $res->fetch_assoc();
	$category = new \edocs\Category($res_cat['cid'], $res_cat['name'], $res_cat['code'], $res_cat['description'], $res_cat['parent'], new MySQLDataLoader($db));
}

$res_cats = $db->executeQuery("SELECT * FROM rb_categories $exclude ORDER BY name");

include "category.html.php";