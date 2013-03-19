<?php 
session_start();
require_once'../../Controlleur/conf/fonction.php';
	require_once'../../Modele/espaceClient/voirRdvPra.php';
	$rdv = voirRdvPra($_SESSION['id']);// récupère les rdv pris avec un praticien en fonction de l'id client
	$date = date('Y-m-d');// recupere la date du jour au format US
echo'<h5>Mes prochains Rendez-vous : </h5>';
echo'<table class="table table-hover table-bordered">';
echo'<th style="text-align:center";>Date</th><th style="text-align:center";>Heure</th><th style="text-align:center";>Cabinet</th><th style="text-align:center";>Praticien</th><th style="text-align:center";>Supprimer</th>';
foreach( $rdv AS $r )
{
	if( $date <= $r['dat_date'] )
	{
		echo'<tr><td style="text-align:center";>'.convertionDate($r['dat_date']).'</td><td style="text-align:center";>'.substr($r['heu_heures'], 0, 5).'</td><td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['cab_nom'].'</a></td><td style="text-align:center";><a href="../espacePublic/details.php?cab='.$r['cab_nom'].'">'.$r['pra_nom'].'</a></td>';
		if(verifierDelaisSuppression($r['dat_date']))
		{
			?>
						<td style="text-align:center";><b><a style="cursor : pointer;" onclick="supprimerCrenauxPraticien('<?php echo $r['cre_id'];?>')"><i class="icon-trash"></i> Supprimer</a></b></td>
					<?php 
				}	
				else
					echo'<td style="text-align:center"; class="alert warning-alert"><b><i class="icon-lock"></i> Un rendez-vous doit etre annulé au minimum 48h à l\'avance</b></td>';
				echo'</tr>';
			}
		}
echo'</table></br>';
?>