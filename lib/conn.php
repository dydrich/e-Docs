<?php

// local copy
$db = new MySQLConnection("localhost", "root", "isildur", "edocs", "3306");
$db->set_charset("utf8");

// dydrich.net copy
//$db = new MySQLConnection("dydrichedocs.mysql.db", "dydrichedocs", "gOlconda666", "dydrichedocs", "3306");
//$db->set_charset("utf8");
//print "Connection ok";