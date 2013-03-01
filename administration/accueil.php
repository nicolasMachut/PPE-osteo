<?php
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();

include(ABSPATH."inc/generateDate.php");

$active_pra = "lA_btn";
if(isset($_GET["ap"]))
  $active_pra = $_GET["ap"];
if(isset($_GET["d"]) AND $_GET["d"]>=0) {// si la date est valable
    $d=htmlentities($_GET["d"]);
    if($d>=50) { // bloquer grande date depassant celle de la base de donnŽe
        $err_d=1;
        $d=49;
    }
}
else // dans tout les autres cas, si d est negatif
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
<?php
    if(isset($err_d)) { // si une erreur sur la date est detectŽe, afficher bandeau erreur
?>
        <div class="alert alert-error">  
            <a class="close" data-dismiss="alert">x</a>  
            <strong>Erreur!</strong> Impossible de prendre des rendez-vous plus loin
        </div>
<?php
    }
?>
        <h2 class="week-title">
          <a href="?d=<?php echo $d-1; ?>&ap=<?php echo $active_pra ?>" id="weekless" class="nav-date"> < </a>
          Semaine du <?php echo date("d/m/y", $dateBeginWeek) ?> au <?php echo date("d/m/y", $dateEndWeek) ?>
          <a href="?d=<?php echo $d+1; ?>&ap=<?php echo $active_pra ?>" id="weekmore" class="nav-date"> > </a>
        </h2>
        
        <div class="tabbable tabs-left">
            <!--<ul class="nav nav-pills" id="sort-date">
                <li onclick="changeClassLi(this)"><a href="#">Par jour</a></li>
                <li class="active" onclick="changeClassLi(this)"><a href="#">Par semaine</a></li>
                <li onclick="changeClassLi(this)"><a href="#">Par mois</a></li>
                <a href="rdvinfo.php?id=7749">blhblah</a>
            </ul>-->
            <ul class="nav nav-tabs">
<?php           $cabinet=$_SESSION["cab"];
                include(ABSPATH."praticiensTabs.php"); ?>
            </ul>
            <!--DIV-->
<?php
            //createTabsPraticiens($_GET["c"]);
            //$cabinet=$_GET["c"];
            include(ABSPATH."praticienPlanning.php");

?>
        </div> <!-- /tabble -->
        <!-- Modal -->
        <div id="rdvModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel">Prise de rendez-vous</h3>
            </div>
            <form class="form-horizontal form-search" method="post" action="add_rdv.php"> <!-- formulaire d'inscription de nouveau client -->
                <div class="modal-body">
                  <!--<div class="control-group">
                    <div class="input-append">
                      <input type="text" class="span2 search-query" placeholder="Rechercher client...">
                      <button type="submit" class="btn">Search</button>
                    </div>
                  </div>-->
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
        </div> <!-- /modal rdv -->
        <div id="rdvInfoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Informations sur le rendez-vous</h3>
          </div>
          <div class="modal-body">
            <div style="width: 140px;float: left">
                <span class="moreInfosSpan">Nom : </span>
                <span class="moreInfosSpan">Prenom :</span>
                <div class="moreInfos">
                    <span class="moreInfosSpan">Adresse :</span>
                    <span class="moreInfosSpan">Adresse :</span>
                    <span class="moreInfosSpan">Code postal :</span>
                    <span class="moreInfosSpan">Ville :</span>
                    <span class="moreInfosSpan">Telephone :</span>
                    <span class="moreInfosSpan">Email :</span>
                </div>
                <span class="moreInfosSpan">Praticien :</span>
                <span class="moreInfosSpan">Motif :</span>
                <span class="moreInfosSpan">Le</span>
                <span class="moreInfosSpan">à</span>
            </div>
            <div style="float: left" class="updateMoreInfos">
                <span id="rdvInfoLastName" class="moreInfosSpan"></span>
                <span id="rdvInfoFirstName" class="moreInfosSpan"></span>
                <div class="moreInfos">
                    <form id="moreInfosForm">
                        <span class="moreInfosSpan"><input type="text" name="adress1" /></span>
                        <span class="moreInfosSpan"><input type="text" name="adress2" /></span>
                        <span class="moreInfosSpan"><input type="text" name="postalCode" /></span>
                        <span class="moreInfosSpan"><input type="text" name="city" /></span>
                        <span class="moreInfosSpan"><input type="text" name="telephone" /></span>
                        <span class="moreInfosSpan"><input type="text" name="email" /></span>
                        <input type="hidden" id="inputPwd" name="pwd" />
                    </form>
                </div>
                <span id="rdvInfoPraticienName" class="moreInfosSpan"></span>
                <span id="rdvInfoSubject" class="moreInfosSpan"></span>
                <span id="rdvInfoDate" class="moreInfosSpan"></span>
                <span id="rdvInfoHour" class="moreInfosSpan"></span>
            </div>
          </div>
          <button id="moreInfosClientBtn" class="btn btn-large btn-block btn-primary" type="button">Veuillez saisir les informations complementaires</button>
          <div class="modal-footer">
            <button type="button" id="submitMoreInfos" class="btn btn-success">Valider les informations complementaires</button>
            <button id="absentRdvClient_btn" class="btn btn-warning editDispo_btn" data-dismiss="modal" dispo="3" aria-hidden="true">Absent</button>
            <button id="cancelRdv_btn" class="btn btn-danger editDispo_btn" data-dismiss="modal" dispo="0" aria-hidden="true">Annuler</button>
            <button id="arrivalClient_btn" class="btn btn-primary editDispo_btn" data-dismiss="modal" dispo="4" aria-hidden="true">Arrivé</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
          </div>
        </div> <!-- /modal rdv info -->
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
                    $(planning_cells[cell]).attr("class","empty-cell");
                    $(planning_cells[cell]).attr("data-toggle", "modal");
                    $(planning_cells[cell]).attr("data-target", "#rdvModal");
                } else {
                    $(planning_cells[cell]).attr("class","rdv");
                    $(planning_cells[cell]).attr("data-toggle", "modal");
                    $(planning_cells[cell]).attr("data-target", "#rdvInfoModal");
                    if($(planning_cells[cell]).attr("dispo") == 3)
                      $(planning_cells[cell]).css("background-color", "#F99A14");
                    else if($(planning_cells[cell]).attr("dispo") == 4)
                      $(planning_cells[cell]).css("background-color", "#004FCC");                    
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
     
	var ac_config = {
		source: "autocomplete_names.php",
		select: function(event, ui){
			$("#inputLastName").val(ui.item.cli_nom);
			$("#inputFirstName").val(ui.item.cli_prenom);
			$("#inputPostalCode").val(ui.item.cli_cp);
                        $('#inputTitle').val(ui.item.civ_id);
		},
		minLength:1
	};
        
	$("#inputLastName").autocomplete(ac_config);
        
        var activepra = <?php echo $active_pra; ?>;
        $(activepra).trigger("click");
        
        $(".tab_pra").click(function (){
          var pra = $(this).attr("id");
          $("#weekless").attr("href", $("#weekless").attr("href")+"&ap="+pra);
          $("#weekmore").attr("href", $("#weekmore").attr("href")+"&ap="+pra);
        });
        
        
        $(".rdv").click(function (){
          $("#rdvInfoModal").attr("crenauId", $(this).attr("id"));
          if($(this).attr("datetime") < Math.floor($.now()/1000))
            $("#cancelRdv_btn").hide();
          else
            $("#cancelRdv_btn").show();
            
          var idsInfos = ["rdvInfoLastName", "rdvInfoFirstName", "rdvInfoPraticienName", "rdvInfoSubject", "rdvInfoDate", "rdvInfoHour"];
          var crenauInfo = new Array();
          $.post("http://ppeepsi2016.franceserv.com/administration/views/rdvinfo.php?id="+$(this).attr("id"), '', function(data, textStatus) {
            crenauInfo = data.split(',');
            var p = $("#rdvInfoModal").find(".modal-body");
            for(var i=0;i<crenauInfo.length;i++){
              $("#"+idsInfos[i]).append(crenauInfo[i]);
            }
            if(crenauInfo[6]==1)
                $("#moreInfosClientBtn").hide();
            else
                $("#moreInfosClientBtn").show();
          });
          
          $("#rdvInfoModal").find(".modal-body").find(".updateMoreInfos").html(
                '<span id="rdvInfoLastName" class="moreInfosSpan"></span>                                          '+
                '<span id="rdvInfoFirstName" class="moreInfosSpan"></span>                                         '+
                '<div class="moreInfos">                                                                           '+
                '    <form id="moreInfosForm">                                                                     '+
                '        <span class="moreInfosSpan"><input type="text" name="adress1" /></span>                   '+
                '        <span class="moreInfosSpan"><input type="text" name="adress2" /></span>                   '+
                '        <span class="moreInfosSpan"><input type="text" name="postalCode" /></span>                '+
                '        <span class="moreInfosSpan"><input type="text" name="city" /></span>                      '+
                '        <span class="moreInfosSpan"><input type="text" name="telephone" class="telephone"/></span> '+
                '        <span class="moreInfosSpan"><input type="text" name="email" /></span>                     '+
                '        <input type="hidden" id="inputPwd" name="pwd" />                                          '+
                '    </form>                                                                                       '+
                '</div>                                                                                            '+
                '<span id="rdvInfoPraticienName" class="moreInfosSpan"></span>                                     '+
                '<span id="rdvInfoSubject" class="moreInfosSpan"></span>                                           '+
                '<span id="rdvInfoDate" class="moreInfosSpan"></span>                                              '+
                '<span id="rdvInfoHour" class="moreInfosSpan"></span>                                              '
              );
            $(".moreInfos").hide();
            $("#submitMoreInfos").hide();
            $("#submitMoreInfos").attr("crenauId", $(this).attr("id"));
            
        });
        
        $(".editDispo_btn").click(function() {
          var crenau = $("#"+$("#rdvInfoModal").attr("crenauId"));
          var dispo = $(this).attr("dispo");
          $.post("http://ppeepsi2016.franceserv.com/administration/edit_crenau.php?id="+$("#rdvInfoModal").attr("crenauId")+"&dispo="+dispo, '', function(data, textStatus) {
            if(dispo == 4)
              $(crenau).css("background-color", "#004FCC");
            else if(dispo == 3)
             $(crenau).css("background-color", "#F99A14");
            else if(dispo == 0)
              top.location = "accueil.php";
          });
        });
        
        $("#moreInfosClientBtn").click(function (){
            $("#moreInfosClientBtn").hide();
            $("#submitMoreInfos").show();
            $(".moreInfos").show();
        });
        
        $("#submitMoreInfos").click(function (){
            $("#inputPwd").val(generateRandomPassword(4));
            var dataToBeSent = $("#moreInfosForm").serialize();
            $.post("http://ppeepsi2016.franceserv.com/administration/add_moreInfosClient.php?id="+$(this).attr("crenauId"), dataToBeSent, function(data, textStatus) {
            });
            $('.close').trigger("click");
        });
        
        $(".telephone").keyup(function (){
            alert("hey");
            //$(this).val(function(i, text) {
            //text = text.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, "$1.$2.$3.$4.$5");
            //return text;
            //});            
        });
    </script>
  </body>
<?php
$obj_db->db_close1();
?>
</html>