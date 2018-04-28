<?php

require_once "../lib/start.php";
require_once "../lib/Document.php";

ini_set('display_errors', 1);

$document = null;
$register = false;
if (isset($_REQUEST['register']) && $_REQUEST['register'] == 1) {
	$register = true;
}
$document = new \edocs\Document($_GET['did'], null, null, new MYSQLDataLoader($db));
try{
	$document->download($register);
} catch (\edocs\MySQLException $ex){
	echo "kosql|".$ex->getQuery()."|".$ex->getMessage();
	exit;
}
