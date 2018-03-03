<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 21/10/17
 * Time: 23.12
 */
require_once "../lib/start.php";

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';

$res_subs = $db->executeQuery("SELECT * FROM rb_subjects ORDER BY name");

$drawer_label = "Materie e discipline";

include "subjects.html.php";