<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 08/09/18
 * Time: 18.28
 */
require_once "../lib/start.php";

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';

$res_channels = $db->executeQuery("SELECT * FROM rb_channels ORDER BY level, name");

$drawer_label = "Canali";

include "channels.html.php";