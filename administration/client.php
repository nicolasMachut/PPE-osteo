<?php
$typePage = "other";
define('ABSPATH', dirname(__FILE__).'/');

require(ABSPATH."inc/config.php");
require_once(ABSPATH.'inc/db.php');
require_once(ABSPATH.'inc/functions.php');
require_once(ABSPATH.'inc/checklogin.php');

$obj_db->db_connect1();
$clients = getClients();
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
        <table class="table table-condensed table-striped client">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Ville</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
<?php foreach($clients as $client){ ?>
              <tr clientId="<?php echo $client["cli_id"]; ?>">
                <td><?php echo $client["cli_nom"] ?></td>
                <td><?php echo $client["cli_prenom"] ?></td>
                <td><?php echo $client["cli_ville"] ?></td>
                <td>
                    <span class="moreInfosClient" clientId="<?php echo $client["cli_id"]; ?>" data-toggle="modal" data-target="#clientInfoModal" style="cursor: pointer"><i class="icon-info-sign"></i></span>
                </td>
                <td>
                    <span class="editInfosClient" clientId="<?php echo $client["cli_id"]; ?>" data-toggle="modal" data-target="#clientInfoModal" style="cursor: pointer"><img src="assets/img/glyphicons/glyphicons_136_cogwheel.png" /></span>
                    <span class="removeClient" clientId="<?php echo $client["cli_id"]; ?>" style="cursor: pointer"><i class="icon-trash"></i></span>
                </td>
              </tr>
<?php } ?>
            </tbody>
        </table>
        <div id="clientInfoModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Informations sur le client</h3>
          </div>
          <div class="modal-body">
            <div style="float: left; width: 140px">
                <span class="moreInfosSpan">Civilité : </span>
                <span class="moreInfosSpan">Nom : </span>
                <span class="moreInfosSpan">Prenom :</span>
                <span class="moreInfosSpan">Adresse :</span>
                <span class="moreInfosSpan">Complement :</span>
                <span class="moreInfosSpan">Code postal :</span>
                <span class="moreInfosSpan">Ville :</span>
                <span class="moreInfosSpan">Telephone :</span>
                <span class="moreInfosSpan">Email :</span>
            </div>
            <div style="float: left" class="updateMoreInfos">
              <form id="editInfosForm">
                <span class="moreInfosSpan" id="clientInfoGender">
                  <select id="inputTitle" name="inputTitle">        
                      <option value="0">Choisissez</option>         
                      <option id="gender_5" value="5">Mr.</option>  
                      <option id="gender_6" value="6">Mme.</option> 
                      <option id="gender_7" value="7">Mlle.</option>
                  </select>                                         
                </span>
                <span class="moreInfosSpan" id="clientInfoLastName">  <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoFirstName"> <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoAdress1">   <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoAdress2">   <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoCP">        <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoCity">      <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoPhone">     <input type="text" name="c" /></span>
                <span class="moreInfosSpan" id="clientInfoMail">      <input type="text" name="c" /></span>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary editInfo_btn" data-dismiss="modal" aria-hidden="true">Valider</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
          </div>
    </div> <!-- /container -->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script type="text/javascript">
      $(".modal-footer").hide();
      
        $(".moreInfosClient").click(function (){
          $(".modal-footer").hide();
          $(".updateMoreInfos").html(
            '<span class="moreInfosSpan" id="clientInfoGender"> </span> '+
            '<span class="moreInfosSpan" id="clientInfoLastName"></span>'+
            '<span class="moreInfosSpan" id="clientInfoFirstName"></span>  '+
            '<span class="moreInfosSpan" id="clientInfoAdress1"></span>    '+
            '<span class="moreInfosSpan" id="clientInfoAdress2"></span>    '+
            '<span class="moreInfosSpan" id="clientInfoCP"></span>         '+
            '<span class="moreInfosSpan" id="clientInfoCity"></span>       '+
            '<span class="moreInfosSpan" id="clientInfoPhone"></span>      '+
            '<span class="moreInfosSpan" id="clientInfoMail"></span>       '
          );
          
          var idsInfos = ["clientInfoGender", "clientInfoLastName", "clientInfoFirstName", "clientInfoAdress1", "clientInfoAdress2", "clientInfoCP", "clientInfoCity", "clientInfoPhone", "clientInfoMail"];
          var crenauInfo = new Array();
          $.post("http://ppeepsi2016.franceserv.com/administration/views/clientinfo.php?id="+$(this).attr("clientId"), '', function(data, textStatus) {
              crenauInfo = data.split(',');
              var p = $("#clientInfoModal").find(".modal-body");
              for(var i=0;i<crenauInfo.length;i++){
                  $("#"+idsInfos[i]).append(crenauInfo[i]);
              }
          });
        });
        
        $(".editInfosClient").click(function (){
          $(".modal-footer").show();
          $(".updateMoreInfos").html(
            '<form id="editInfosForm">                                                                                        '+
            '   <span class="moreInfosSpan" id="clientInfoGender">                                                            '+
            '     <select id="inputTitle" name="inputTitle">                                                                  '+
            '         <option value="0">Choisissez</option>                                                                   '+
            '         <option id="gender_5" value="5">Mr.</option>                                                            '+
            '         <option id="gender_6" value="6">Mme.</option>                                                           '+
            '         <option id="gender_7" value="7">Mlle.</option>                                                          '+
            '     </select>                                                                                                   '+
            '   </span>                                                                                                       '+
            '   <span class="moreInfosSpan" id="clientInfoLastName">       <input type="text" name="inputLastName" /></span>  '+
            '   <span class="moreInfosSpan" id="clientInfoFirstName">      <input type="text" name="inputFirstName" /></span> '+
            '   <span class="moreInfosSpan" id="clientInfoAdress1">        <input type="text" name="inputAdress1" /></span>   '+
            '   <span class="moreInfosSpan" id="clientInfoAdress2">        <input type="text" name="inputAdress2" /></span>   '+
            '   <span class="moreInfosSpan" id="clientInfoCP">             <input type="text" name="inputCP" /></span>        '+
            '   <span class="moreInfosSpan" id="clientInfoCity">           <input type="text" name="inputCity" /></span>      '+
            '   <span class="moreInfosSpan" id="clientInfoPhone">          <input type="text" name="inputPhone" /></span>     '+
            '   <span class="moreInfosSpan" id="clientInfoMail">           <input type="text" name="inputMail" /></span>      '+
            '<form id="editInfosForm">                                                                                        '
          );
          var idsInfos = ["clientInfoGender", "clientInfoLastName", "clientInfoFirstName", "clientInfoAdress1", "clientInfoAdress2", "clientInfoCP", "clientInfoCity", "clientInfoPhone", "clientInfoMail"];
          var crenauInfo = new Array();
          $.post("http://ppeepsi2016.franceserv.com/administration/views/clientinfo.php?id="+$(this).attr("clientId")+"&type=2", '', function(data, textStatus) {
              crenauInfo = data.split(',');
              var p = $("#clientInfoModal").find(".modal-body");
              for(var i=0;i<crenauInfo.length;i++){
                if(i != 0)
                  $("#"+idsInfos[i]).find('input').val(crenauInfo[i]);
                else
                  $("#"+idsInfos[i]).find('select').val(crenauInfo[i]);
              }
          });
          
          $(".editInfo_btn").attr("clientId", $(this).attr("clientId"));
        });
        
        $(".editInfo_btn").click(function (){
          var dataToBeSent = $("#editInfosForm").serialize();
          $.post("http://ppeepsi2016.franceserv.com/administration/editclientinfo.php?id="+$(this).attr("clientId"), dataToBeSent, function(data, textStatus) {
          });
        });
        
        $(".removeClient").click(function (){
          $(this).parent().parent().find('td').fadeOut("fast");
          $.post("http://ppeepsi2016.franceserv.com/administration/removeclient.php?id="+$(this).attr("clientId"), '', function(data, textStatus) {
          });
        });
    </script>
  </body>
<?php
$obj_db->db_close1();
?>
</html>