<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 19/10/17
 * Time: 6.48
 */
require_once "../lib/start.php";

check_session();
check_role(User::$USER);

$_SESSION['area'] = 'admin';

$doc_count = $db->executeCount("SELECT COUNT(*) FROM rb_documents WHERE owner = ".$_SESSION['__user__']->getUid());

$drawer_label = "Home";

include "index.html.php";