<?php

	require_once'../../Controlleur/conf/connexionBDD.php';
	global $bdd;
	if( isset($_REQUEST['date']) && isset($_REQUEST['salle']) && isset($_REQUEST['heure']) && isset($_REQUEST['idClient']) )
	{
		$date = $_REQUEST['date'];
		$salle = $_REQUEST['salle'];
		$heure = $_REQUEST['heure'];
		$idClient = $_REQUEST['idClient'];
		
		$reponse = $bdd -> query('
		 INSERT INTO PrendRDV (sal_id, dat_date, heu_heures, cli_id)
				VALUE("'.$salle.'", "'.$date.'", "'.$heure.'", "'.$idClient.'");
				');
		
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
	