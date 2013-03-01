<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

if(!empty($_POST["inputLastName"]) && !empty($_POST["inputEmail"])) {
    //mail ( $_POST["inputEmail"], "Creation de votre compte OSTEO" , "Bonjour, \n\nVotre mot de passe est ".$_POST['inputPwd'].".\n\nNous vous conseillons de vite le changer pour mieux vous en rappeler.\n\nCordialement.");
    insertPraticien($_POST["inputLastName"],$_POST["inputFirstName"],$_POST["inputEmail"],$_POST["inputGrade"],$_POST["inputPwd"],$_POST["inputTitle"],$_POST["inputCabinet"]);
    $dates=getDatesFromNow();
    $id=getLastAddedPraticien();
    $id=$id["pra_id"];
    //browseDateAndHourAndInsertCrenau($dates, $id);
    //header("location: accueil.php");
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
            <h1>Ajouter un praticien</h1>
            <form class="form-horizontal" action="addpraticien.php" method="post">
                <div class="control-group">
                    <label class="control-label" for="inputTitle">Civilite :</label>
                    <div class="controls">
                        <select id="inputTitle" name="inputTitle">
                            <option value="0">Choisissez</option>
                            <option id="gender_5" value="5">Mr.</option>
                            <option id="gender_6" value="6">Mme.</option>
                            <option id="gender_7" value="7">Mlle.</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputLastName">Nom :</label>
                  <div class="controls">
                    <input type="text" name="inputLastName" placeholder="Nom">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputFirstName">Prénom :</label>
                  <div class="controls">
                    <input type="text" name="inputFirstName" placeholder="Prénom">
                  </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                      <input type="text" name="inputEmail" placeholder="Email">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputGrade">Grade :</label>
                    <div class="controls">
                        <select name="inputGrade">
                            <option value="0">Choisissez</option>
                            <option value="5">Responsable</option>
                            <option value="6">Praticien</option>
                            <option value="7">Secretaire</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputCabinet">Cabinet :</label>
                    <div class="controls">
                        <select name="inputCabinet">
                            <option value="0">Choisissez</option>
                            <option value="5">BLANQUEFORT</option>
                            <option value="6">LABRIT</option>
                            <option value="7">BISCA</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                    <input type="hidden" name="inputPwd" id="inputPwd" />
                    <button type="submit" id="submit_btn" class="btn">Ajouter</button>
                  </div>
                </div>
            </form>
        </div> <!-- /le container -->   

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/functions.js"></script>
        <script type="text/javascript">
            $("#submit_btn").click(function(){
               $("#inputPwd").val(generateRandomPassword(4));
            });
        </script>
    </body>
<?php
$obj_db->db_close1();
?>
</html>