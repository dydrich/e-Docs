<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 08/10/17
 * Time: 11.52
 */

ini_set("display_errors", 1);

require_once "lib/start.php";
require_once "lib/Authenticator.php";
//require_once "lib/EventLogFactory.php";

$_SESSION['__path_to_root__'] = "/";
//header("Content-type: text/plain");
//header("Content-type: application/json");
$response = array();

$nick = $db->real_escape_string($_POST['my-username']);
$pass = $db->real_escape_string($_POST['pw']);
$pwd = md5($pass);

$authenticator = new Authenticator(new MySQLDataLoader($db));
try {
	$user = $authenticator->login($nick, $pwd);
} catch (\edocs\MySQLException $ex){
	$response['status'] = "kosql";
	$response['query'] = $ex->getQuery();
	$response['message'] = $ex->getMessage();
	echo json_encode($response);
	exit;
} catch (Exception $e){
	$response['status'] = "ko";
	$response['message'] = $e->getMessage();
	echo json_encode($response);
	exit;
}

if ($user == null) {
	echo "null";
}

$_SESSION['__user__'] = $user;
if ($_POST['area'] == 'admin') {
	header("Location: admin/index.html");
}
else {
	header("Location: back/index.html");
}

//echo $authenticator->getStringAjax();
$response = $authenticator->getResponse();
//echo json_encode($response);
//exit;
