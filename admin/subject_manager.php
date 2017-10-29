<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 22/10/17
 * Time: 11.24
 */
require_once "../lib/start.php";
require_once "../lib/Subject.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$name = null;
$parent = 0;
if($_POST['action'] != ACTION_DELETE){
	if (isset($_POST['sub'])) {
		$name = $db->real_escape_string(trim($_POST['sub']));
	}
	$parent = $_POST['parent'];
}
$sid = $_POST['sid'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$subject = new \edocs\Subject(0, $name, $parent, new MySQLDataLoader($db));
			$subject->insert();
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
		$msg = "Disciplina inserita";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$subject = new \edocs\Subject($sid, '', null, new MySQLDataLoader($db));
			$subject->delete();
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
		$msg = "Disciplina cancellata";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$subject = new \edocs\Subject($sid, $name, $parent, new MySQLDataLoader($db));
			$subject->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Disciplina aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
