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
	$res = $db->executeQuery("SELECT file, document_type, link FROM rb_documents WHERE doc_id = $doc_id");
} catch (\edocs\MySQLException $ex) {

}
$data = $res->fetch_assoc();

$response['query'] = 'SELECT file, document_type, link FROM rb_documents WHERE doc_id = $doc_id';
$response['file'] = $data['file'];
$response['res_link'] = $data['link'];
$response['type'] = $data['document_type'];

$res = json_encode($response);
echo $res;
exit;
