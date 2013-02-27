<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

if(!empty($_GET["praticien"])) {
    insertPraticien($_GET["praticien"]);
    $dates=getDatesFromNow();
    $id=getLastAddedPraticien();
    $id=$id["pra_id"];
    browseDateAndHourAndInsertCrenau($dates, $id);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php
        include("views/head.php");
?>
    </head>
    <body>
<?php
    include("views/header.php");
?>
        <div id="container">
<form action="addpraticien.php" method="get">
<input type="text" name="praticien" id="praticien"  placeholder="Nom" />
</form>
        </div> <!-- /le container -->   

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
<?php
$obj_db->db_close1();
?>
</html>