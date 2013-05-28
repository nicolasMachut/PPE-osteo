<?php
	require_once'../../Modele/espaceClient/voirRdvPra.php';
	$rdv = voirRdvPra($_SESSION['id']);// récupère les rdv pris avec un praticien en fonction de l'id client
	$date = date('Y-m-d');// recupere la date du jour au format US
	if( $rdv == NULL ) // Si le client n'a jamais pris de rdv avec un praticien
	{
		echo'<h5>Vous n\'avez encore jamais pris rendez-vous, vous pouvez contacter l\'un de nos cabinets afin de prendre un rendez-vous à votre convenance</h5>';
	}
	else
	{
		echo'<div id="listeProchainCrenauxPraticien"></div>';
		
		echo'<h5>Historique des Rendez-vous : </h5>';
		echo'<table class="table table-striped table-bordered">';
		echo'<th style="text-align:center";>Date</th><th style="text-align:center";>Heure</th><th style="text-align:center";>Cabinet</th><th style="text-align:center";>Praticien</th>';
		foreach( $rdv AS $r )
		{
			if( $date > $r['dat_date'] )
				echo'<tr><td style="text-align:center";>'.convertionDate($r['dat_date']).'</td><td style="text-align:center";>'.substr($r['heu_heures'], 0, 5).'</td><td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['cab_nom'].'</a></td><td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['pra_nom'].'</a></td></tr>';
		}
		echo'</table>';
	}
?>
	<script src="../../Vue/assets/js/jquery-1.8.3.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	
	
	<script>
	$(document).ready(function(){
		$.post('../../Vue/espaceClient/listeProchainCrenauxPraticien.php', '', function(data){
			$('#listeProchainCrenauxPraticien').html(data);
			});
	});
		function supprimerCrenauxPraticien( creId )
		{
			$.post('../../Controlleur/espaceClient/supprimerCrenauxPraticien.php?id='+creId+'', '' , function(data, textStatus) {});
			$.post('../../Vue/espaceClient/listeProchainCrenauxPraticien.php', '', function(data){
				$('#listeProchainCrenauxPraticien').html(data);
				});
		}
	</script>

