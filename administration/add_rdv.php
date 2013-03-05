<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();
if(isset($_POST["inputTitle"]) && issetAndNotEmpty($_POST["lastName"]) && issetAndNotEmpty($_POST["firstName"]) && issetAndNotEmpty($_POST["postalCode"])) {
  $title=mysql_real_escape_string($_POST["inputTitle"]);
  $lastName=mysql_real_escape_string($_POST["lastName"]);
  $firstName=mysql_real_escape_string($_POST["firstName"]);
  $postalCode=mysql_real_escape_string($_POST["postalCode"]);
  
  $client=clientExist($lastName, $firstName, $postalCode);
  if($client && count($client)<2)
    editCrenau($client[0]["cli_id"], $_POST["crenauId"]);
  else {
    insertClient($title, $lastName, $firstName, $postalCode);
    $client=clientExist($lastName, $firstName, $postalCode);
    editCrenau($client[0]["cli_id"], $_POST["crenauId"]);
  }
}

header("location: ".$_SERVER["HTTP_REFERER"]);
?>