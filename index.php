<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 08/10/17
 * Time: 18.44
 */
require_once "lib/start.php";

if(!isset($_SESSION['__config__'])){
	include_once "lib/load_env.php";
}

include "index-html.php";