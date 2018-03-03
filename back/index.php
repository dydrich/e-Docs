<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 19/10/17
 * Time: 6.48
 */

require_once "../lib/start.php";

check_session();
check_role(\edocs\User::$USER);

$_SESSION['area'] = 'admin';

try {
	$doc_count = $db->executeCount("SELECT COUNT(*) FROM rb_documents WHERE owner = ".$_SESSION['__user__']->getUid());
	$doc_m_count = $db->executeCount("SELECT COUNT(*) FROM rb_documents WHERE upload_date BETWEEN DATE_SUB(NOW(), INTERVAL + 1 MONTH) AND NOW() AND owner = ".$_SESSION['__user__']->getUid());
} catch (\edocs\MySQLException $ex) {

}

$drawer_label = "Home";

include "index.html.php";