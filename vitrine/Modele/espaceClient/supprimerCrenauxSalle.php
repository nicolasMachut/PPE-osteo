<?php 
require_once'../../Controlleur/conf/connexionBDD.php';
function supprimerCrenauxSalle($id, $date, $heure)
{
	global $bdd;
	$reponse = $bdd -> query('
			DELETE FROM PrendRDV WHERE cli_id='.$id.' AND heu_heures="'.$heure.'" AND dat_date="'.$date.'"  	
			');
	return $reponse;
}
?>
