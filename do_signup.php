<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 29/04/18
 * Time: 17.13
 */

ini_set("display_errors", 1);

require_once "lib/start.php";
require_once "lib/User.php";
//require_once "lib/EventLogFactory.php";

header("Content-type: application/json");
$response = array("status" => "ok", "message" => "Account registrato");

$fname = $db->real_escape_string($_POST['fname']);
$lname = $db->real_escape_string($_POST['lname']);
$nick = $db->real_escape_string($_POST['new-username']);
$pass = $db->real_escape_string($_POST['npw']);
$en_pass = md5($pass);
$pwd = ['c' => $pass, 'e' => $en_pass];

$user = new \edocs\User(0, $fname, $lname, $nick, $pwd, \edocs\User::$GUEST, new MySQLDataLoader($db));
try {
	$access_data = $user->insert(\edocs\User::$ACTIVATION_EMAIL);
	echo "user added";
} catch (\edocs\MySQLException $ex){
	$response['status'] = "kosql";
	$response['query'] = $ex->getQuery();
	$response['message'] = $ex->getMessage();
	$_SESSION['mysqlerror'] = $response;
	$res = json_encode($response);
	echo $res;
	exit;
} catch (\edocs\CustomException $e){
	$response['status'] = "ko";
	$response['message'] = $e->getMessage();
	$response['code'] = $e->getCode();
	$response['detail'] = $e->__toString();
	$_SESSION['error'] = $response;
	$res = json_encode($response);
	echo $res;
	exit;
}

$response["status"] = "ok";
$response['nick'] = $nick;
$response['role'] = $user->getRole();
$res = json_encode($response);
echo $res;
exit;
