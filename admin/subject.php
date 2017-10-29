<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 22/10/17
 * Time: 10.58
 */
require_once "../lib/start.php";
require_once "../lib/Subject.php";

check_session();
check_role(User::$ADMIN);

$_SESSION['area'] = 'admin';
$drawer_label = null;
if ($_GET['sid'] == 0) {
	$drawer_label = "Nuova disciplina";
}
else {
	$drawer_label = "Modifica disciplina";
	$exclude = "WHERE sid != ".$_GET['sid'];
	$res = $db->executeQuery("SELECT * FROM rb_subjects WHERE sid = ".$_GET['sid']);
	$res_sub = $res->fetch_assoc();
	$subject = new \edocs\Subject($res_sub['sid'], $res_sub['name'], $res_sub['parent'], new MySQLDataLoader($db));
}

$res_subs = $db->executeQuery("SELECT * FROM rb_subjects $exclude ORDER BY name");

include "subject.html.php";