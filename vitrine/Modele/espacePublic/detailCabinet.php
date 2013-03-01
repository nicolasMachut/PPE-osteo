<?php 
	require_once('../../Controlleur/conf/connexionBDD.php');
	
	function detailCabinet( $cab )//Renvoie les informations sur les cabinets
	{
		$cabinet = array();
		global $bdd;
		$reponse = $bdd -> query('SELECT * FROM Cabinet WHERE cab_nom="'.$cab.'"');
		if ( $donne = $reponse -> fetch() )
			$cabinet[] = $donne;
		
		return $cabinet;
	}
	
	//--------------------------------------------------------------------------------
	
	function detailPraticien( $cab ) //renvoie les informations sur les praticiens
	{
		$praticien = array();
		global $bdd;
		$reponse = $bdd -> query('
				SELECT * FROM Praticien 
				WHERE Praticien.cab_id=(SELECT cab_id FROM Cabinet WHERE cab_nom="'.$cab.'");
				');
		while( $donne = $reponse -> fetch() )
		{
			$praticien[] = $donne;
		}
		return $praticien;
	}
?>