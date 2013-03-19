<?php 
	require_once'../../Controlleur/conf/fonction.php';
	require_once'../../Modele/espaceClient/voirRdvSal.php';
	if( empty($_POST['date1']) )
		$_POST['date1'] = date('Y-m-d');
?>


<div class="alert alert-info">
	<h3>Réserver un crénaux</h3>
	<form class="form-inline" method="post" id="formCrenaux">
		<label for="cab">Choisissez un cabinet :</label>
		<select name="cab" id="cab" class="selectRDV">
			<?php
				nomCabinet();
			?>
		</select>
		<label for="date1">Choisissez une date :</label>
		<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
			<tr>
				<td id="ds_calclass"></td>
			</tr>
		</table>
		<input type="text" name="date1" id="julien" onclick="ds_sh(this);" value="<?php echo $_POST['date1']?>" class="selectRDV"/>
		<div id="planning"></div><div>
		<table>
			<th id="crenauxTable"></th>
		</table>
	</div>
</div>

<div id="confirmation" class="alert alert-warning" style="display : none;"></div>
<div class="alert alert-success" id="afficherSucces" style="display : none">
	<p>Le crénaux a bien été réservé.</p>
</div>

<!-- Affichage des crénaux réservés -->

<?php

	require_once'../../Modele/espaceClient/voirRdvSal.php';
	$rdv = voirRdvSal($_SESSION['id']);
	if($rdv == NULL)
	{
		echo'<h5>Vous n\'avez encore jamais réservé de crénaux dans l\'une de nos salles, contactez l\'un de nos cabinet ou utilisez le formulaire ci-dessus afin de réserver un crénaux.</h5>';
	}
	else
	{
		?>
		<div id="listeProchainCrenaux">
		
		</div>
		<?php 
		$date = date('Y-m-d');
		echo'<h5>Historique des crénaux réservés : </h5>';
		echo'<table class="table table-striped table-bordered">';
		echo'<th style="text-align:center";>Date</th><th style="text-align:center";>Heure</th><th style="text-align:center";>Salle</th><th style="text-align:center";>Cabinet</th>';
		foreach($rdv AS $r)
		{
			if($date > $r['dat_date'])
			{
				echo'<tr>
						<td style="text-align:center";>'.convertionDate($r['dat_date']).'</td>
						<td style="text-align:center";>'.substr($r['heu_heures'], 0, 5).'</td>
						<td style="text-align:center;">'.$r['sal_id'].'</td>
						<td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['cab_nom'].'</a></td>
					</tr>';
			}
		}
	}
	?>
</table>
	<script src="../../Vue/assets/js/jquery-1.8.3.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<script>
	function afficherValidation(heure, idClient, salle, date, dateNonConvertis)
	{
		$('#afficherSucces').hide();
		supprimerValidation();
		
		document.getElementById('confirmation').style.display="block";

		//Création recapitulatif crénaux
		var newP = document.createElement('p');
		newP.id = "pConfirm";
		var newPText = document.createTextNode('Le : ' + date + ' à ' + heure + ' dans la salle : ' + salle);

		//Création titre
		var newTitre = document.createElement('p');
		newTitre.id = "pTitre";
		var newTitreText = document.createTextNode('Réserver un crénaux : ');

		//Création lien confirmation
		var newLinkConfirm = document.createElement('a');
		newLinkConfirm.id = 'aConfirm';
		
		newLinkConfirm.addEventListener('click', function(){confirmerCrenaux(date, heure, salle, idClient, dateNonConvertis);}, false);
		$(newLinkConfirm).css('cursor', 'pointer');
		var newLinkConfirmText = document.createTextNode('Confirmer ');

		//création lien annulation
		var newLinkAnnul = document.createElement('a');
		newLinkAnnul.id = 'aAnnul';
		newLinkAnnul.setAttribute('onclick', 'supprimerValidation()');
		$(newLinkAnnul).css('cursor', 'pointer');
		var newLinkAnnulText = document.createTextNode('Annuler');

		//appendChild
		newP.appendChild(newPText);
		newLinkConfirm.appendChild(newLinkConfirmText);
		newLinkAnnul.appendChild(newLinkAnnulText);
		newTitre.appendChild(newTitreText);

		//affichage 
		document.getElementById('confirmation').appendChild(newTitre);
		document.getElementById('confirmation').appendChild(newP);
		document.getElementById('confirmation').appendChild(newLinkConfirm);
		document.getElementById('confirmation').appendChild(newLinkAnnul);
		
	}


	function supprimerValidation()
	{
		if( document.getElementById('confirmation').hasChildNodes() )
		{
			var pConfirm = document.getElementById('pConfirm');
			pConfirm.parentNode.removeChild(pConfirm);
	
			var aConfirm = document.getElementById('aConfirm');
			aConfirm.parentNode.removeChild(aConfirm);
	
			var aAnnul = document.getElementById('aAnnul');
			aAnnul.parentNode.removeChild(aAnnul);

			var pTitre = document.getElementById('pTitre');
			pTitre.parentNode.removeChild(pTitre);

			document.getElementById('confirmation').style.display="none";
		}
	}

	function confirmerCrenaux(date, heure, salle, idClient, dateNonConvertis)
	{
		$.post("../../Modele/espaceClient/reserverCrenauxSalle.php?date="+dateNonConvertis+"&heure="+heure+"&salle="+salle+"&idClient="+idClient, ' ', function(data, textStatus) {});
		$.post('../../Vue/espaceClient/listeProchainCrenaux.php', '', function(data){
			$('#listeProchainCrenaux').html(data);
			var dataToBeSent = $('#formCrenaux').serialize();
			$.post('../../Vue/espaceClient/planningSalle.php', dataToBeSent, function(data, textStatus){
				$('#planning').html(data);
			});
			});
		$('#afficherSucces').show();
		supprimerValidation();
	}
	
	</script>

<script type="text/javascript">
$(document).ready(function(){
		
	$.post('../../Vue/espaceClient/listeProchainCrenaux.php', '', function(data){
			$('#listeProchainCrenaux').html(data);
			});
	function loadPlanning()
	{
		var dataToBeSent = $('#formCrenaux').serialize();
		$.post('../../Vue/espaceClient/planningSalle.php', dataToBeSent, function(data, textStatus){
			$('#planning').html(data);
		});
	}
	loadPlanning();
	$('.selectRDV').on('change', function(){
			loadPlanning();
	});
});


</script>

