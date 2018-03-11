<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 11/03/18
 * Time: 10.41
 */
require_once "../lib/start.php";

check_session();

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "");
$doc_id = $_REQUEST['doc_id'];
try {
	$fname = $db->executeCount("SELECT file FROM rb_documents WHERE doc_id = $doc_id");
} catch (\edocs\MySQLException $ex) {

}

$response['query'] = 'SELECT file FROM rb_documents WHERE doc_id = $doc_id';
$response['file'] = $fname;
$res = json_encode($response);
echo $res;
exit;
