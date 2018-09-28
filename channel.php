<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 28/04/18
 * Time: 19.23
 */

require_once "lib/start.php";
require_once "lib/load_env.php";
require_once "lib/Channel.php";
require_once "lib/User.php";

ini_set('display_errors', 1);

$channel = new \edocs\Channel($_REQUEST['cid'], null, null, null, null, null, null, new \edocs\User(0, null, null, null, null, null, new MySQLDataLoader($db)), new MySQLDataLoader($db), null);
$channel->reloadData();
$sel_categorie = "SELECT * FROM rb_categories ORDER BY name";
$sel_subjects = "SELECT * FROM rb_subjects ORDER BY name";
$subs = $channel->getSubchannels();

$subchannels = [];
if (count($subs) > 0) {
	foreach ($subs as $sub) {
		$ch = new \edocs\Channel($sub, null, null, null, null, null, null, new \edocs\User(0, null, null, null, null, null, new MySQLDataLoader($db)), new MySQLDataLoader($db), null);
		$ch->reloadData();
		$subchannels[] = $ch;
	}
}

$docs = [];
if ($channel->isSubjectChannel()){
	$subject = $channel->getSubject();
	try {
		$res_sub_docs = $db->executeQuery("SELECT rb_documents.*, rb_categories.name AS category, icon, rb_subjects.name AS sub FROM rb_documents, rb_categories, rb_subjects WHERE category = cid AND subject = $subject AND subject = sid ORDER BY last_modified_time DESC");
		if ($res_sub_docs->num_rows > 0) {
			while ($r = $res_sub_docs->fetch_assoc()) {
				$docs[] = ['doc_id' => $r['doc_id'], 'name' => $r['title'], 'category' => $r['category'], 'icon' => $r['icon'], 'field' => $r['sub'], 'date' => $r['last_modified_time']];
			}
		}
	} catch (\edocs\MySQLException $ex) {

	}
}
try {
	$res_categorie = $db->executeQuery($sel_categorie);
	$res_subjects = $db->executeQuery($sel_subjects);
} catch (\edocs\MySQLException $ex) {

}

$drawer_label = "Canale: ".$channel->getName();

include "channel.html.php";