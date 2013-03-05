<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');

$obj_db->db_connect1();

$id = mysql_real_escape_string($_GET["id"]);
$title = mysql_real_escape_string($_POST["inputTitle"]);
$lastName = mysql_real_escape_string($_POST["inputLastName"]);
$firstName = mysql_real_escape_string($_POST["inputFirstName"]);
$adress1 = mysql_real_escape_string($_POST["inputAdress1"]);
$adress2 = mysql_real_escape_string($_POST["inputAdress2"]);
$cp = mysql_real_escape_string($_POST["inputCP"]);
$city = mysql_real_escape_string($_POST["inputCity"]);
$phone = mysql_real_escape_string($_POST["inputPhone"]);
$mail = mysql_real_escape_string($_POST["inputMail"]);

editClientInfo($id, $title, $lastName, $firstName, $adress1, $adress2, $cp, $city, $phone, $mail);

$obj_db->db_close1();
?>