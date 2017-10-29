<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/10/17
 * Time: 10.14
 */
require_once "../lib/start.php";
require_once "../lib/Tag.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$name = $description = null;
if($_POST['action'] != ACTION_DELETE){
	$name = $db->real_escape_string(trim($_POST['sub']));
	$description = $db->real_escape_string($_POST['textarea']);
}
$tid = $_POST['tid'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$tag = new \edocs\Tag(0, $name, $description, new MySQLDataLoader($db));
			$tag->insert();
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Etichetta inserita";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$tag = new \edocs\Tag($tid, '', '', new MySQLDataLoader($db));
			$tag->delete();
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$db->executeUpdate("ROLLBACK");
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Etichetta eliminata";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$tag = new \edocs\Tag($tid, $name, $description, new MySQLDataLoader($db));
			$tag->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Etichetta aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
