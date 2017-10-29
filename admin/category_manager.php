<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 24/10/17
 * Time: 7.19
 */
require_once "../lib/start.php";
require_once "../lib/Category.php";

check_session(AJAX_CALL);

if (!isset($_POST['action'])) {
	echo "NOT ISSET";
}

$name = $description = $code = null;
$parent = 0;
if($_POST['action'] != ACTION_DELETE){
	$name = $db->real_escape_string(trim($_POST['sub']));
	$description = $db->real_escape_string($_POST['textarea']);
	$code = $db->real_escape_string($_POST['code']);
	$parent = $_POST['parent'];
}
$cid = $_POST['cid'];

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Operazione completata");

switch($_POST['action']){
	case ACTION_INSERT:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$category = new \edocs\Category(0, $name, $code, $description, $parent, new MySQLDataLoader($db));
			$category->insert();
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
		$msg = "Categoria inserita";
		break;
	case ACTION_DELETE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$category = new \edocs\Category($cid, '', '', '', null, new MySQLDataLoader($db));
			$category->delete();
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
		$msg = "Categoria eliminata";
		break;
	case ACTION_UPDATE:
		try{
			$begin = $db->executeUpdate("BEGIN");
			$category = new \edocs\Category($cid, $name, $code, $description, $parent, new MySQLDataLoader($db));
			$category->update();
			$commit = $db->executeUpdate("COMMIT");
		} catch (\edocs\MySQLException $ex){
			$response['status'] = "kosql";
			$response['message'] = "Operazione non completata a causa di un errore";
			$response['dbg_message'] = $ex->getMessage();
			$response['query'] = $ex->getQuery();
			echo json_encode($response);
			exit;
		}
		$msg = "Categoria aggiornata";
		break;
}

$response['message'] = $msg;
echo json_encode($response);
exit;
