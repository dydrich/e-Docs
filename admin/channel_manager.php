<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 10/09/18
 * Time: 17.08
 */
require_once "../lib/start.php";
require_once "../lib/Channel.php";

ini_set('display_errors', 1);

check_session();
check_role(\edocs\User::$ADMIN);

$name = $description = null;
if($_POST['action'] != ACTION_DELETE){
	$name = $db->real_escape_string(trim($_POST['name']));
	$description = $db->real_escape_string(trim($_POST['desc']));
	$system = $_POST['system'];
	$school = $_POST['school'];
	$grade = $_POST['grade'];
	$subject = $_POST['subject'];
	$owner = $_SESSION['__user__']->getUid();
	$subchannel_of = null;
	if (isset($_POST['subchannel-of'])) {
		$subchannel_of = $_POST['subchannel-of'];
	}
}
$cid = $_POST['cid'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$channel = new \edocs\Channel(0, $name, $description, $system, $school, $grade, $subject, $_SESSION['__user__'], new MySQLDataLoader($db), null);
			$channel->insert();
			if ($subchannel_of != null) {
				$channel->setParents($subchannel_of);
			}
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
		$msg = "Canale inserito";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$channel = new \edocs\Channel($cid, null, null, null, null, null, null, $_SESSION['__user__'], new MySQLDataLoader($db), null);
			$channel->delete();
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
		$msg = "Canale cancellato";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$channel = new \edocs\Channel($cid, $name, $description, null, $school, $grade, $subject, $_SESSION['__user__'], new MySQLDataLoader($db), null);
			$channel->update();
			if ($subchannel_of != null) {
				$channel->setParents($subchannel_of);
			}
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			$response['message'] = "Operazione non completata a causa di un errore SQL. Errore: ".$response['dbg_message'] = $ex->getMessage()."===".$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Canale aggiornato";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;