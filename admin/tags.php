<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.13
 */
require_once "../lib/start.php";

check_session();
check_role(User::$ADMIN);

$_SESSION['area'] = 'admin';

$res_tags = $db->executeQuery("SELECT * FROM rb_tags ORDER BY name");

$drawer_label = "Tag";

include "tags.html.php";