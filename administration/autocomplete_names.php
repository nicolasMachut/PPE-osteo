<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

$clients = getClients();
 
// Cleaning up the term
$term = trim(strip_tags($_GET['term']));
 
// Rudimentary search
$matches = array();
foreach($clients as $client){
	if(stripos($client['cli_nom'], $term) !== false){
		// Add the necessary "value" and "label" fields and append to result set
		$client['value'] = $client['cli_nom'];
		$client['label'] = "{$client['cli_nom']} {$client['cli_prenom']}, {$client['cli_cp']}";
		$matches[] = $client;
	}
}
 
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 5);
print json_encode($matches);

$obj_db->db_close1();
?>