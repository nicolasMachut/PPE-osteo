<?php
require_once'../../Controlleur/conf/connexionBDD.php';

	function voirRdvSal ($id)
	{
		$rdv = array();
		global $bdd;
		$reponse = $bdd -> query('
		SELECT dat_date, heu_heures, PrendRDV.sal_id, cab_nom
		FROM PrendRDV
		INNER JOIN Salle ON Salle.sal_id=PrendRDV.sal_id 
		INNER JOIN Cabinet ON Cabinet.cab_id=Salle.cab_id 
		WHERE cli_id='.$id.'
		ORDER BY dat_date DESC
		');
			while($donnee = $reponse -> fetch())
			{
				$rdv[] = $donnee;
			}
			return $rdv; // renvoie les rdv en salle d'un client
	}
	
	//-------------------------------------------------------------------------------
	
	function getSalle($cab)
	{
		$salle = array();
		global $bdd;
		$reponse = $bdd -> query('
				SELECT sal_id 
				FROM Salle
				WHERE Salle.cab_id = (SELECT cab_id FROM Cabinet WHERE cab_nom = "'.$cab.'") 
				');
		while($donnee = $reponse -> fetch())
		{
			$salle[] = $donnee;
		}
		return $salle; // renvoie l'id des salles d'un cabinet
	}
	
	//--------------------------------------------------------------------------------
	
	function getHeure()
	{
		$heure = array();
		global $bdd;
		$reponse = $bdd -> query('
				SELECT heu_heures FROM Heure
				');
		while($donnee = $reponse -> fetch())
		{
			$heure[] = $donnee;
		}
		return $heure; // renvoie la liste des heures 
	}
	
	//--------------------------------------------------------------------------------
	
	function  nbPersInscrit($date, $heure, $salle)
	{
		global $bdd;
		
		$repNbPersInscrit = $bdd -> query('
				SELECT COUNT(cli_id) FROM PrendRDV WHERE sal_id='.$salle.' AND heu_heures="'.$heure.'" AND dat_date="'.$date.'"
				');
		$donneeNbPersInscrit = $repNbPersInscrit -> fetch();//$donneeNbPersInscrit = nombre de personne inscrite dans la salle choisis a l'heure choisis a une date choisis
		return $donneeNbPersInscrit['COUNT(cli_id)'];
	}
	
	//--------------------------------------------------------------------------------
	
	function nbPersMax($salle)
	{
		global $bdd;
		
		$repNbPersMax = $bdd -> query('
				SELECT sal_nbPersMax FROM Salle WHERE sal_id = '.$salle.'
				');
		$donneeNbPersMax = $repNbPersMax -> fetch(); //$donneeNbPersMax = nombre de personne maximum dans la salle choisis
		return $donneeNbPersMax['sal_nbPersMax'];
	}
	
	
	//---------------------------------------------------------------------------------
	
	function nomCabinet()
	{
		global $bdd;
		$reponse = $bdd -> query('SELECT cab_id, cab_nom FROM Cabinet');
		while($cabinet = $reponse -> fetch())
		{
			echo'<option>'.$cabinet['cab_nom'].'</option>';
		}
	}

