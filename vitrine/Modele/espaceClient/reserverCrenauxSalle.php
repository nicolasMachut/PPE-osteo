<?php
	require_once'../../Controlleur/conf/connexionBDD.php';
	
	function reserverCrenauxSalle($salle, $date, $heure, $idClient) // Réserve un nouveau crénaux
	{
		
		global $bdd;
		$reponse = $bdd -> query('
				INSERT INTO PrendRDV (sal_id, dat_date, heu_heures, cli_id)
				VALUE("'.$salle.'", "'.$date.'", "'.$heure.'", "'.$idClient.'");
				');
		return $reponse;
	}
	
	/*function verifierDoubleRdv($idClient, $date, $heure)
	{
		global $bdd;
		$reponse = $bdd -> query('
				SELECT * FROM PrendRdv WHERE cli_id = '.$idClient.' AND dat_date = '.$date.' AND heu_heures = '.$heure.'
				');
		if($donnee = $reponse -> fetch())
			$PrendRdv = true;
		
		$reponse2 = $bdd -> query('
				
				');
	}*/
	
	function voirCabinetClient($idClient)
	{
		
	}