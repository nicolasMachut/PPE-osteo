<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');

$obj_db->db_connect1();
include(ABSPATH."inc/generateDate.php");
if(isset($_GET["title"]) && issetAndNotEmpty($_GET["lastName"]) && issetAndNotEmpty($_GET["firstName"]) && issetAndNotEmpty($_GET["postalCode"])) {
  $title=mysql_real_escape_string($_GET["title"]);
  $lastName=mysql_real_escape_string($_GET["lastName"]);
  $firstName=mysql_real_escape_string($_GET["firstName"]);
  $postalCode=mysql_real_escape_string($_GET["postalCode"]);
   switch($title) {
    case "Mr." :
      $title=1;
      break;
    case "Mme." :
      $title=2;
      break;
    case "Mlle." :
      $title=3;
      break;
  }
  $client=clientExist($lastName, $firstName, $postalCode);
  if($client && count($client)<2)
    editCrenau($client[0]["cli_id"], $_GET["crenauId"]);
  else {
    insertClient($lastName, $firstName, $postalCode);
    $client=clientExist($lastName, $firstName, $postalCode);
    editCrenau($client[0]["cli_id"], $_GET["crenauId"]);
  }
}

if(isset($_GET["d"]) AND $_GET["d"]>=0)
  $d=htmlentities($_GET["d"]);
else
  $d=0;
  
$dateBeginWeek=strtotime("+".$d." week", strtotime('monday this week'));
$dateEndWeek=strtotime('sunday this week', $dateBeginWeek);
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
        <h2 class="week-title"><a href="?d=<?php echo $d-1; ?>" class="nav-date"><</a> Semaine du <?php echo date("d/m/y", $dateBeginWeek) ?> au <?php echo date("d/m/y", $dateEndWeek) ?> <a href="?d=<?php echo $d+1; ?>" class="nav-date">></a></h2>
        
        <div class="tabbable tabs-left">
            <ul class="nav nav-pills" id="sort-date">
                <li onclick="changeClassLi(this)"><a href="#">Par jour</a></li>
                <li class="active" onclick="changeClassLi(this)"><a href="#">Par semaine</a></li>
                <li onclick="changeClassLi(this)"><a href="#">Par mois</a></li>
            </ul>
            <ul class="nav nav-tabs">
                <!--<li class="active"><a href="#lA" data-toggle="tab">Michel</a></li>
                <li><a href="#lB" data-toggle="tab">Claude</a></li>
                <li><a href="#lC" data-toggle="tab">House</a></li>-->
<?php           $cabinet=$_GET["c"];
                include(ABSPATH."praticiensTabs.php"); ?>
            </ul>
            <!--DIV-->
<?php
            //createTabsPraticiens($_GET["c"]);
            //$cabinet=$_GET["c"];
            include(ABSPATH."praticienPlanning.php");

?>
            <!--</div>-->
        </div> <!-- /tabble -->
        <!-- Modal -->
        <div id="rdvModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel">Prise de rendez-vous</h3>
            </div>
                <form class="form-horizontal form-search" method="get" action="accueil.php?"> <!-- formulaire d'inscription de nouveau client -->
                    <div class="modal-body">
                      <div class="control-group">
                        <div class="input-append">
                          <input type="text" class="span2 search-query" placeholder="Rechercher client...">
                          <button type="submit" class="btn">Search</button>
                        </div>
                      </div>
                        <div class="control-group">
                            <label class="control-label" for="inputTitle">Civilite :</label>
                            <div class="controls">
                                <select id="inputTitle" name="title">
                                    <option>Choisissez</option>
                                    <option>Mr.</option>
                                    <option>Mlle.</option>
                                    <option>Mme.</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="lastName">Nom :</label>
                            <div class="controls">
                                <input type="text" id="inputLastName" name="lastName" placeholder="Nom">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="firstName">Prenom :</label>
                            <div class="controls">
                                <input type="text" id="inputFirstName" name="firstName" placeholder="Prenom">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="postalCode">Code Postal :</label>
                            <div class="controls">
                                <input type="text" id="inputPostalCode" name="postalCode" placeholder="Code Postal">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="null" id="crenauId" name="crenauId"/>
                    <input type="hidden" value="<?php echo $cabinet;?>" name="c"/>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                    <button class="btn btn-primary" type="submit">Confirmer</button>
                </div>
            </form>
        </div>
    </div> <!-- /le container -->   

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script  src="assets/js/jquery-1.8.3.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function getCrenauId(crenau) { // prend l'id de chaque crenau et le renvoi a PHP
          var crenauId = crenau.id;
          document.getElementById("crenauId").value = crenauId;
        }
        
        for(var i=1; i<=<?php echo countPraticiens($cabinet); ?>; i++) { // change les cellules de chaque praticien
            changeClassEmptyCell(i);
        }
    
        function changeClassEmptyCell(i) { // Pour colorer les cases vides en vert, et les rendre cliquable
            var planning_cells=document.getElementById("planning"+i).getElementsByTagName("td"); // charge le planning du praticien
            for(var cell in planning_cells) {
                if(planning_cells[cell].innerText=="") {
                    planning_cells[cell].className="empty-cell";
                    planning_cells[cell].setAttribute("data-toggle", "modal");
                    planning_cells[cell].setAttribute("data-target", "#rdvModal");
                }
            }
        }
        
        function changeClassLi(active_li){ // changement couleur tri jour/semaine/mois
            var list_li=document.getElementById("sort-date").getElementsByTagName("li");
            for(var li in list_li) {
                list_li[li].className="";
            }
            active_li.className="active";
        }
    </script>
  </body>
<?php
$obj_db->db_close1();
?>
</html>