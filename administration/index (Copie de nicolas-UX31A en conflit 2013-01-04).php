<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');

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

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Osteo</h2>
        <input type="text" class="input-block-level" placeholder="Identifiant" name="login">
        <input type="password" class="input-block-level" placeholder="Mot de passe" name="password">
        <button class="btn btn-large btn-primary" type="submit">Connexion</button>
      </form>
<?php
if(isset($_POST["login"]) && isset($_POST["password"])) {
  $login=mysql_real_escape_string($_POST["login"]);
  $pwd=mysql_real_escape_string($_POST["password"]);

  if(getUserCabinet($login, $pwd)==0) {
?>
      <div class="alert alert-error">  
        <a class="close" data-dismiss="alert">x</a>  
        <strong>Erreur!</strong> Mot de passe et/ou nom d'utilisateur incorrect.
      </div>
<?php
  }
  else {
    $cab=getUserCabinet($login, $pwd); //recupere donnŽe table cabinet
    $cab=$cab[0]["cab_id"]; // recupere l'id du cabinet
?>
      <div class="alert alert-success">  
        <a class="close" data-dismiss="alert">x</a>  
        <strong>Succes!</strong>  
      </div>
      <div class="progress progress-striped active">
        <div id="progressBar" class="bar" style="width: 1%;" <!--onclick="modifBar()"-->></div>
      </div>
      <script language="Javascript">
        <!--
          alert("acces autorise");
          window.setTimeout(document.location.replace("accueil.php?c="+<?php echo $cab ?>), 3000);
          
        // -->
      </script>
<?php
  }
}
?>
   
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script  src="assets/js/jquery-1.8.3.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      /*function modifBar() {
        alert(document.getElementById('progressBar').style.);
        var progressBar=document.getElementById('progressBar');
        progressBar.style.width="50%";
      }
        
      function progressBar() {
        alert("dans fct");
        //for(var i=0; i<=4; i++)
          setInterval(modifBar(), 1000);
      }*/
    </script>
  </body>
<?php
$obj_db->db_close1();
?>
</html>