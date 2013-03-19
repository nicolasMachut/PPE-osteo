	<?php 
	session_start();
	require_once'../../Controlleur/conf/fonction.php';
	require'../../Modele/espaceClient/voirRdvSal.php';
	?>
	</br><h5>Liste des prochains crénaux : </h5>
	<table class="table table-hover table-bordered">
	<th style="text-align:center";>Date</th><th style="text-align:center";>Heure</th><th style="text-align:center";>Cabinet</th><th style="text-align:center";>Salle</th><th style="text-align:center";>Supprimer</th>
<?php 
$date = date('Y-m-d');
$rdv = voirRdvSal($_SESSION['id']);
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
		{
			?>
				<td style="text-align:center";><b><a style="cursor : pointer;" onClick="supprimerCrenaux('<?php echo $r['dat_date'];?>','<?php echo $r['heu_heures'];?>')"><i class="icon-trash"></i> Supprimer</a></b></td>
			<?php 
		}
		else
			echo'<td class="alert alert-warning" style="text-align:center";><b><i class="icon-lock"></i> Un rendez-vous doit etre supprimé au minimum 48h à l\'avance</b></td>';
		echo'</tr>';
	}
}
echo '</table></br>';