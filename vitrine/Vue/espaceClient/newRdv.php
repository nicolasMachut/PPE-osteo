<?php 
	require_once'../../Controlleur/conf/fonction.php';
	require_once'../../Modele/espaceClient/voirRdvSal.php';
?>


<div class="alert alert-info">
	<h3>Réserver un crénaux</h3>
	<form class="form-inline" method="post">
		<label for="cab">Choisissez un cabinet :</label>
		<select name="cab" id="cab">
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
		<input type="text" name="date1" onclick="ds_sh(this);" />
		<input type="submit" id="ok"/>
		<?php 

				echo'<h5>Liste des crénaux du '.$_POST['date1'].' pour le cabinet de '.$_POST['cab'].'</h5>';
		?>
		<div id="crenauxDispo" style="width : 100%; overflow : auto;">
			<table class="table table-bordered">
				<th style="text-align:center";>Salle</th>
				<?php 
					$salle = getSalle($_POST['cab']);
					$heure = getHeure();
					foreach($heure AS $heu)
					{
						echo'<th style="text-align:center";>'.substr($heu['heu_heures'], 0, 5).'</th>';
					}
					foreach($salle AS $sal)
					{
						echo'<tr><td style="text-align:center";>'.$sal['sal_id'].'</td>';
						foreach($heure AS $heu)
						{
							$nbPersInscrit = nbPersInscrit("2013-01-30", $heu['heu_heures'], $sal['sal_id']);
							$nbPersMax = nbPersMax($sal['sal_id']);
							if(voirCrenauxDispo("2013-01-30",$heu['heu_heures'], $sal["sal_id"]))
							{
								?>
									<td class = "alert alert-success" onClick="confirm('Voulez vous réserver ce crénaux ?')" style="text-align:center";><?php echo $nbPersInscrit." / ".$nbPersMax;?></td>
								<?php 
							}
							else
							{
								?>
									<td class = "alert alert-error" onClick="alert('Ce crénaux est complet. Veuillez en choisir un autre.')" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
								<?php 
								
							}
							
						}
						echo'</tr>';
					}
			
?>

		
			</table>
		</form>
	</div>

	
	<div>
		<table>
			<th id="crenauxTable"></th>
		</table>
	</div>
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
			</br><h5>Liste des prochains crénaux : </h5>
			<table class="table table-hover table-bordered">
			<th style="text-align:center";>Date</th><th style="text-align:center";>Heure</th><th style="text-align:center";>Cabinet</th><th style="text-align:center";>Salle</th><th style="text-align:center";>Supprimer</th>
		<?php 
		$date = date('Y-m-d');
		foreach($rdv AS $r)
		{
			if($date <= $r['dat_date'])
			{
				$afficherDateRdv = convertionDate($r["dat_date"]);
				echo'<tr>';
				echo'<td style="text-align:center";>'.$afficherDateRdv.'</td><td style="text-align:center";>'.substr($r['heu_heures'], 0, 5).'</td>';
				echo'<td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['cab_nom'].'</a></td>';
				echo'<td style="text-align:center";>'.$r['sal_id'].'</td>';
				if(verifierDelaisSuppression($r['dat_date']))
					echo'<td style="text-align:center";><b><a href="../../Controlleur/espaceClient/supprimerCrenauxSalle.php?heure='.$r[heu_heures].'&date='.$r[dat_date].'"><i class="icon-trash"></i> Supprimer</a></b></td>';
				else
					echo'<td class="alert alert-warning" style="text-align:center";><b><i class="icon-lock"></i> Un rendez-vous doit etre supprimé au minimum 48h à l\'avance</b></td>';
				echo'</tr>';
			}
			
		}
		echo '</table></br>';
		echo'<h5>Historique des crénaux réservés : </h5>';
		echo'<table class="table table-striped table-bordered">';
		echo'<th style="text-align:center";>Date</th><th style="text-align:center";>Heure</th><th style="text-align:center";>Cabinet</th>';
		foreach($rdv AS $r)
		{
			if($date > $r['dat_date'])
			{
				echo'<tr>
						<td style="text-align:center";>'.convertionDate($r['dat_date']).'</td>
						<td style="text-align:center";>'.substr($r['heu_heures'], 0, 5).'</td>
						<td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['cab_nom'].'</a></td>
					</tr>';
			}
		}

	}
	?>
</table>

<script>

	function afficherValidation()
	{
		alert("validation");
	}
	
	
	function VoirCrenauxDisponibles(){
			var cabinet=$('#cab').val(),
				inputdate=$('input[name="date1"]').val();
				
			if(/(\d{2})\/(\d{2})\/(\d{4})/.test(inputdate)) {
				var date=inputdate.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1' );
					
					
				$.ajax({
						url:"recupererCrenaux.php",
						data: {date: date, cab: cabinet},
						type: "POST"
				})
				.done(function(res){
					var crenaux=JSON.parse(res);
					var table=$('<table/>');
					$('#crenauxTable').html("");
					table.appendTo($('#crenauxTable'));
					$(crenaux).each(function(){
							$('<tr/>').html('<td>'+this.heu_heures+'</td>').appendTo(table);
					})
				})
			}
	}
	
	$('.ds_cell').live('click', function(){
			VoirCrenauxDisponibles();
	});
	$('#cab').on('change', function(){
			VoirCrenauxDisponibles();
	})
</script>

