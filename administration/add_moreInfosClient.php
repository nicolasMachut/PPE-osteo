<?php
//http://youtu.be/p0EzL9E-2UY?t=2m16s
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();
if(!empty($_POST["adress1"])){
    //mail ( $_POST["email"], "Creation de votre compte OSTEO" , "Bonjour, \n\nVotre mot de passe est ".$_POST['pwd'].".\n\nNous vous conseillons de vite le changer pour mieux vous en rappeler.\n\nCordialement.");
    $id=mysql_real_escape_string($_GET["id"]);
    $adress1=mysql_real_escape_string($_POST["adress1"]);
    $adress2=mysql_real_escape_string($_POST["adress2"]);
    $pc=mysql_real_escape_string($_POST["postalCode"]);
    $city=mysql_real_escape_string($_POST["city"]);
    $tel=mysql_real_escape_string($_POST["telephone"]);
    $email=mysql_real_escape_string($_POST["email"]);
    $pwd=mysql_real_escape_string($_POST["pwd"]);

    updateMoreInfosClients($id, $adress1, $adress2, $pc, $city, $tel, $email, $pwd);
}
?>
