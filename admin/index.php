<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/10/17
 * Time: 21.37
 */
require_once "../lib/start.php";

$users_count = $db->executeCount("SELECT COUNT(*) FROM rb_users WHERE role <> 3");

$drawer_label = "Dashboard";

include "index.html.php";