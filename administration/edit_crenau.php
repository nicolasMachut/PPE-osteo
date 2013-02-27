<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');

$obj_db->db_connect1();

$dispo = mysql_real_escape_string($_GET["dispo"]);
$id = mysql_real_escape_string($_GET["id"]);
editCrenauDispo($id, $dispo);

$obj_db->db_close1();
?>