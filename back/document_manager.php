<?php

require_once "../lib/start.php";
require_once '../lib/EventLogFactory.php';
require_once "../lib/Document.php";

$response = array("status" => "ok");
header("Content-type: application/json");

if ($_POST['action'] == \edocs\Document::$QUICK_DELETE){
	$f = $_POST['server_file'];
	$fp = $_SESSION['__config__']['document_root']."/{$f}";

	if (file_exists($fp)){
		unlink($fp);
	}
	else {
		$response['status'] = "ko";
		$response['message'] = "Il file richiesto ({$fp}) non è presente sul server";
		$res = json_encode($response);
		echo $res;
		exit;
	}
	$response['message'] = "Il file è stato cancellato";
	$res = json_encode($response);
	echo $res;
	exit;
}

try{
	switch ($_POST['action']){
		case \edocs\Document::$INSERT_DOCUMENT:
			$data = [];
			$data['title'] = $db->real_escape_string($_POST['title']);
			$data['abstract'] = $db->real_escape_string($_POST['abstract']);
			$data['subject'] = $_POST['subject'] != '' ? $_POST['subject'] : null;
			$data['document_type'] = $_POST['type'];
			$data['category'] = $_POST['category'];
			$data['file'] = $_POST['server_file'];
			$data['document_name'] = $_POST['doc_name'];
			$data['link'] = isset($_POST['link']) ? $db->real_escape_string($_POST['link']) : null;
			$data['upload_date'] = null;
			$data['last_modified_time'] = null;
			$data['school'] = $_POST['school'] != '' ? $_POST['school'] : null;
			$data['school_grade'] = $_POST['grade'] != '' ? $_POST['grade'] : null;
			$data['tags'] = $_POST['tags'];
			$data['owner'] = $_SESSION['__user__']->getUid();
			$doc = new \edocs\Document(0, $data, $_POST['category'], new MySQLDataLoader($db));
			$doc->insert();
			$response['message'] = "Il documento è stato inserito";
			break;
		case \edocs\Document::$UPDATE_DOCUMENT:
			$data = [];
			$data['title'] = $db->real_escape_string($_POST['title']);
			$data['abstract'] = $db->real_escape_string($_POST['abstract']);
			$data['subject'] = $_POST['subject'] != '' ? $_POST['subject'] : null;
			$data['document_type'] = $_POST['type'];
			$data['category'] = $_POST['category'];
			$data['document_name'] = $_POST['doc_name'];
			$data['upload_date'] = null;
			$data['last_modified_time'] = null;
			$data['school'] = $_POST['school'] != '' ? $_POST['school'] : null;
			$data['school_grade'] = $_POST['grade'] != '' ? $_POST['grade'] : null;
			$data['tags'] = $_POST['tags'];
			$data['owner'] = $_SESSION['__user__']->getUid();
			$doc = new \edocs\Document($_REQUEST['did'], $data, $_POST['category'], new MySQLDataLoader($db));
			$doc->update();
			$response['message'] = "Il documento è stato modificato";
			break;
		case \edocs\Document::$DELETE_DOCUMENT:
			$doc->delete();
			$response['message'] = "Il documento è stato cancellato";
			break;
	}
} catch (\edocs\MySQLException $ex){
	$response['status'] = "kosql";
	$response['dbg_message'] = "Query: {$ex->getQuery()} ------ Errore: {$ex->getMessage()}";
	$response['message'] = "Si è verificato un errore di rete: controlla lo stato della tua connessione e riprova";
	$res = json_encode($response);
	echo $res;
	exit;
}

$res = json_encode($response);
echo $res;
exit;
