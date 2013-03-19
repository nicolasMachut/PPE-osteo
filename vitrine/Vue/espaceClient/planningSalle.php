<?php 
session_start();
require_once'../../Controlleur/conf/fonction.php';
require_once'../../Modele/espaceClient/voirRdvSal.php';
	if( !empty($_POST['date1']) )
	echo'<h5>Liste des crénaux du '.convertionDate($_POST['date1']).' pour le cabinet de '.$_POST['cab'].'</h5>';
?>
  <div id="crenauxDispo" style="width : 101%; overflow : auto;">
	<table class="table table-bordered">	
		<?php 
		if( !empty($_POST['date1']) )
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
										<td class = "alert alert-success" style="cursor : pointer;" onClick="afficherValidation('<?php echo substr($heu['heu_heures'], 0, 5);?>','<?php echo $_SESSION['id'];?>','<?php echo $sal['sal_id']?>', '<?php echo convertionDate($_POST['date1']);?>','<?php echo $_POST['date1'];?>')" style="text-align:center";><?php echo $nbPersInscrit." / ".$nbPersMax;?></td>
									<?php 
								}
								else
								{
									?>
										<td class = "alert alert-warning" style="cursor : pointer;" onclick="supprimerValidation(), alert('Vous avez déjà un rendez-vous ou réservé un crénaux le <?php echo convertionDate($_POST['date1']);?> à <?php echo substr($heu['heu_heures'], 0, 5);?>.');" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
									<?php 
								}
							}
							else
							{
								?>
									<td class = "alert alert-error" style="cursor : pointer;" onclick="supprimerValidation(), alert('Vous ne pouvez pas réserver de crénaux en dehors des heures d\'ouverture.');" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
								<?php 
							}
						}
						else //si elle est pleine on affiche en rouge
						{
							?>
								<td class = "alert alert-error" style="cursor : pointer;" onclick="supprimerValidation(), alert('La salle est pleine : choisissez une autre salle ou un autre crénaux.');;" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
							<?php 
						}								
					}
					else// le crenaux est passé, la case est affiché en rouge
					{
						?>
							<td class = "alert alert-error" style="cursor : pointer;" onclick="supprimerValidation(), alert('Vous ne pouvez pas réserver de crénaux pour un jour antérieur à la date actuelle.');;" style="text-align:center";><?php echo $nbPersInscrit."/".$nbPersMax;?></td>
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