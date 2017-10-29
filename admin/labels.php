<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 20/10/17
 * Time: 23.54
 */
require_once "../lib/start.php";

check_session();
check_role(User::$ADMIN);

$_SESSION['area'] = 'admin';

$sub_count = $db->executeCount("SELECT COUNT(*) FROM rb_subjects");
$cat_count = $db->executeCount("SELECT COUNT(*) FROM rb_categories");
$tag_count = $db->executeCount("SELECT COUNT(*) FROM rb_tags");

$drawer_label = "Documenti";

include "labels.html.php";