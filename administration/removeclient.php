<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');

$obj_db->db_connect1();

$id = mysql_real_escape_string($_GET["id"]);

removeClient($id);

$obj_db->db_close1();
?>