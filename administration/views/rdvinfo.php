<?php
define('ABSPATH', dirname(__FILE__).'/../');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

$id = mysql_real_escape_string($_GET["id"]);
$crenauInfo = getCrenauById($id);
$moreInfos=0;
if($crenauInfo["cli_adresse1"])
	$moreInfos=1;

echo $crenauInfo["cli_nom"].",".$crenauInfo["cli_prenom"].",".$crenauInfo["pra_nom"].",Mal au genou,".$crenauInfo["dat_date"].",".$crenauInfo["heu_heures"].",".$moreInfos;

$obj_db->db_close1();
?>