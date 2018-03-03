<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 24/10/17
 * Time: 7.08
 */
require_once "../lib/start.php";

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';

$res_cats = $db->executeQuery("SELECT * FROM rb_categories ORDER BY name");

$drawer_label = "Categorie";

include "categories.html.php";