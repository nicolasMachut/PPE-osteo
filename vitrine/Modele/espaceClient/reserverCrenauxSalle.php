<?php

	require_once'../../Controlleur/conf/connexionBDD.php';
	global $bdd;
	$reponse = $bdd -> query('
			INSERT INTO PrendRDV (sal_id, dat_date, heu_heures, cli_id)
			VALUE("'.$salle.'", "'.$date.'", "'.$heure.'", "'.$idClient.'");
			');
	
	echo $_REQUEST['date'];
	//echo $_REQUEST['heure'];
	//echo $_REQUEST['idClient'];
	//echo $_REQUEST['salle'];
	
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
	