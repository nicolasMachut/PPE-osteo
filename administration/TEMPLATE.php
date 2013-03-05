<?php
$typePage = "other";
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

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
    <div class="container" id="content">
        /*
        *
        *
        *
        *
        *
        *
        *
        *
        *
        *
        */
    </div> <!-- /container -->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
<?php
$obj_db->db_close1();
?>
</html>