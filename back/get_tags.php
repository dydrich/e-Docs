<?php

require_once "../lib/start.php";

$param = $_GET['term'];

$sel_tags = "SELECT name FROM rb_tags WHERE rb_tags.name LIKE '%{$param}%' ORDER BY name";
$res_tags = $db->execute($sel_tags);
$tags = array();
while ($us = $res_tags->fetch_assoc()){
	$tags[] = array("value" => $us['name']);
}

$json_tags = json_encode($tags);
echo $json_tags;
exit;