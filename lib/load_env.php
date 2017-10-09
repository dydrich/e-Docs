<?php

// estrazione dati di configurazione
$sel_config = "SELECT * FROM rb_config";
$res_config = $db->executeQuery($sel_config);
$config = array();
while($row = $res_config->fetch_assoc()){
	$config[$row['var']] = stripslashes($row['value']);
}
$_SESSION['__config__'] = $config;