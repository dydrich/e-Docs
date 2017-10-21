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
	$_SESSION['mysqlerror'] = $response;
	// TODO: redirect to mysql error page
	exit;
} catch (\edocs\CustomException $e){
	$response['status'] = "ko";
	$response['message'] = $e->getMessage();
	$response['code'] = $e->getCode();
	$response['detail'] = $e->__toString();
	$_SESSION['error'] = $response;
	header("Location: share/login_errors.php");
	exit;
}

if ($user == null) {
	// TODO: redirect to access error page
}

$_SESSION['__user__'] = $user;
if ($_POST['area'] == 'admin') {
	if ($user->getRole() != User::$ADMIN) {
		// TODO: redirect to no permission page
	}
	header("Location: admin/index.php");
}
else {
	header("Location: back/index.php");
}

$response = $authenticator->getResponse();
