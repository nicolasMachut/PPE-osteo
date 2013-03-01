<?php
if(!isset($typePage)){
    $typePage="other";
}

if(isset($_SESSION["cab"]) && isset($_SESSION["grade"]) && $typePage != "other"){
    header("location: accueil.php");
}

if(!isset($_SESSION["cab"]) && !isset($_SESSION["grade"]) && $typePage != "index") {
    header("location: http://ppeepsi2016.franceserv.com/administration/index.php?err=1");
}



?>