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
		<input type="submit" id="ok" name="ok"/>
		<?php 
				if( isset($_POST['ok']) && !empty($_POST['date1']) )
				echo'<h5>Liste des crénaux du '.convertionDate($_POST['date1']).' pour le cabinet de '.$_POST['cab'].'</h5>';
		?>
		<div id="crenauxDispo" style="width : 101%; overflow : auto;">
			<table class="table table-bordered">	
				<?php 
				if( isset($_POST['ok']) && !empty($_POST['date1']) )
				{
					ajouterDate($_POST['date1']);
					echo'<th style="text-align:center";>Salle</th>';
					$salle = getSalle($_POST['cab']);//récupère la liste des salles du cabinet
					$heure = getHeure();// récupère les heures a afficher dans la bdd
					foreach($heure AS $heu)
					{
						echo'<th style="text-align:center";>'.substr($heu['heu_heures'], 0, 5).'</th>';
					}
					foreach($salle AS $sal)
					{
						echo'<tr><td style="text-align:center";>'.$sal['sal_id'].'</td>';
						foreach($heure AS $heu)
						{
							$nbPersInscrit = nbPersInscrit($_POST['date1'], $heu['heu_heures'], $sal['sal_id']);
							$nbPersMax = nbPersMax($sal['sal_id']);
							if(verifierJourHeureCrenaux($_POST['date1'], $heu['heu_heures']))// Vérifie si le crenaux du rdv est passé, si il n'est pas passé, on affiche en vert
							{
								if(voirCrenauxDispo($_POST['date1'],$heu['heu_heures'], $sal["sal_id"]))//verifie si la salle est pleine, si elle n'est pas pleine on affiche en vert
								{
									if(verificationJourOuverture($_POST['date1']))
									{
										if(empecherDoubleRdv($_POST['date1'], $heu['heu_heures'], $_SESSION['id']))
										{
											?>
												<td class = "alert alert-success" onClick="afficherValidation('<?php echo substr($heu['heu_heures'], 0, 5);?>','<?php echo $_SESSION['id'];?>','<?php echo $sal['sal_id']?>', '<?php echo convertionDate($_POST['date1']);?>')" style="text-align:center";><?php echo $nbPersInscrit." / ".$nbPersMax;?></td>
											<?php 
										}
										else
										{
											?>
												<td class = "alert alert-warning" onclick="supprimerValidation(), alert('Vous avez déjà un rendez-vous ou réservé un crénaux le <?php echo convertionDate($_POST['date1']);?> à <?php echo substr($heu['heu_heures'], 0, 5);?>.');" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
											<?php 
										}
									}
									else
									{
										?>
											<td class = "alert alert-error" onclick="supprimerValidation(), alert('Vous ne pouvez pas réserver de crénaux en dehors des heures d\'ouverture.');" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
										<?php 
									}
								}
								else //si elle est pleine on affiche en rouge
								{
									?>
										<td class = "alert alert-error" onclick="supprimerValidation(), alert('La salle est pleine : choisissez une autre salle ou un autre crénaux.');;" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
									<?php 
								}								
							}
							else// le crenaux est passé, la case est affiché en rouge
							{
								?>
									<td class = "alert alert-error" onclick="supprimerValidation(), alert('Vous ne pouvez pas réserver de crénaux pour un jour antérieur à la date actuelle.');;" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
								<?php 
							}
						}
						echo'</tr>';
					}
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

<div id="confirmation" class="alert alert-warning" style="display : none";"></div>

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

<script>

	function afficherValidation(heure, idClient, salle, date)
	{
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
		
		newLinkConfirm.setAttribute('onClick','confirmerCrenaux()');
		var newLinkConfirmText = document.createTextNode('Confirmer ');

		//création lien annulation
		var newLinkAnnul = document.createElement('a');
		newLinkAnnul.id = 'aAnnul';
		newLinkAnnul.setAttribute('onclick', 'supprimerValidation()');
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

	function confirmerCrenaux(date, heure, salle, idClient)
	{
		$.post("../../Modele/espaceClient/reserverCrenauxSalle.php?date="+date+"&heure="+heure+"&salle="+salle+"&idClient="+idClient, ' ', function(data, textStatus) {alert(data);});
		//Affiche du message html pour montrer que le rdv a ete reserve
		//<div class="alert alert-success">
		//	<button type="button" class="close" data-dismiss="alert">&times;</button>
		//	<p>Le crénaux à bien été réservé.</p>
		//</div>
	}
	
</script>

