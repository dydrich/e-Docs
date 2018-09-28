<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 09/09/18
 * Time: 8.06
 */
require_once "../lib/start.php";
require_once "../lib/Channel.php";
require_once "../lib/RBUtilities.php";

ini_set('display_errors', 1);

check_session();
check_role(\edocs\User::$ADMIN);

$_SESSION['area'] = 'admin';
$drawer_label = null;
if ($_GET['cid'] == 0) {
	$drawer_label = "Nuovo canale";
}
else {
	$drawer_label = "Modifica canale";
	$exclude = 'WHERE idc != '.$_GET['cid'];
	$res_ch = $db->executeQuery("SELECT * FROM rb_channels WHERE idc = ".$_GET['cid']);
	$res = $res_ch->fetch_assoc();
	$rb = RBUtilities::getInstance($db);
	$user = $rb->loadUserFromUid($res['owner']);
	$channel = new \edocs\Channel($res['idc'], $res['name'], $res['description'], $res['system'], $res['school'], $res['grade'], $res['subject'], $user, new MySQLDataLoader($db), null);
}

$res_subs = $db->executeQuery("SELECT * FROM rb_subjects ORDER BY name");
$res_schools = $db->executeQuery("SELECT * FROM rb_schools ORDER BY code");
$res_grades = $db->executeQuery("SELECT * FROM rb_grades ORDER BY grade");
$res_channels = $db->executeQuery("SELECT * FROM rb_channels $exclude ORDER BY name");
$res_relations = $db->executeQuery("SELECT parent_id FROM rb_channels_relations WHERE channel_id = ".$_GET['cid']);

include 'channel.html.php';