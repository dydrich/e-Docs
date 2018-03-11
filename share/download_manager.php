<?php

require_once "../lib/start.php";
require_once "../lib/Document.php";

ini_set('display_errors', 1);

$document = null;
$document = new \edocs\Document($_GET['did'], null, null, new MYSQLDataLoader($db));
try{
	$document->download();
} catch (\edocs\MySQLException $ex){
	echo "kosql|".$ex->getQuery()."|".$ex->getMessage();
	exit;
}
