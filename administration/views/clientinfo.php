<?php
define('ABSPATH', dirname(__FILE__).'/../');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

$id = mysql_real_escape_string($_GET["id"]);
$type = 1;
if(isset($_GET["type"]))
    $type = mysql_real_escape_string($_GET["type"]);
$clientInfo = getClientById($id, $type);

if($type == 1)
    echo $clientInfo["civ_libelle"].",".$clientInfo["cli_nom"].",".$clientInfo["cli_prenom"].",".$clientInfo["cli_adresse1"].",".$clientInfo["cli_adresse2"].",".$clientInfo["cli_cp"].",".$clientInfo["cli_ville"].",".$clientInfo["cli_tel"].",".$clientInfo["cli_mail"];
else
    echo $clientInfo["civ_id"].",".$clientInfo["cli_nom"].",".$clientInfo["cli_prenom"].",".$clientInfo["cli_adresse1"].",".$clientInfo["cli_adresse2"].",".$clientInfo["cli_cp"].",".$clientInfo["cli_ville"].",".$clientInfo["cli_tel"].",".$clientInfo["cli_mail"];
$obj_db->db_close1();
?>