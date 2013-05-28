<?php
	require_once'../../Controlleur/conf/connexionBDD.php';

	function voirRdvSal ( $id )// renvoie les rdv en salle d'un client en fonction de son identifiant
	{
		$date = date('Y-m-d');
		$ancienRdv = array();
		$prochainRdv = array();
		global $bdd;
		$reponse = $bdd -> query('
		SELECT dat_date, heu_heures, PrendRDV.sal_id, cab_nom, PrendRDV.sal_id
		FROM PrendRDV
		INNER JOIN Salle ON Salle.sal_id=PrendRDV.sal_id 
		INNER JOIN Cabinet ON Cabinet.cab_id=Salle.cab_id 
		WHERE cli_id='.$id.'
		ORDER BY dat_date DESC
		');
			while( $donnee = $reponse -> fetch() )
			{
					$rdv[] = $donnee;
			}
			return $rdv;
	}
	
	//-------------------------------------------------------------------------------
	
	function getSalle( $cab ) // renvoie l'id des salles d'un cabinet en fonction de l'identifiant du cabinet
	{
		
		$salle = array();
		global $bdd;
		$reponse = $bdd -> query('
				SELECT sal_id 
				FROM Salle
				WHERE Salle.cab_id = (SELECT cab_id FROM Cabinet WHERE cab_nom = "'.$cab.'") 
				');
		while( $donnee = $reponse -> fetch() )
		{
			$salle[] = $donnee;
		}
		return $salle; 
	}
	
	//--------------------------------------------------------------------------------
	
	function getHeure()// renvoie la liste des heures 
	{
		$heure = array();
		global $bdd;
		$reponse = $bdd -> query('
				SELECT heu_heures FROM Heure
				');
		while( $donnee = $reponse -> fetch() )
		{
			$heure[] = $donnee;
		}
		return $heure; 
	}
	
	//--------------------------------------------------------------------------------
	
	function  nbPersInscrit( $date, $heure, $salle )//renvoie le nb de personne inscrite dans une salle en fonction de l'heure, de la date et de la salle
	{
		global $bdd;
		
		$repNbPersInscrit = $bdd -> query('
				SELECT COUNT(cli_id) FROM PrendRDV WHERE sal_id='.$salle.' AND heu_heures="'.$heure.'" AND dat_date="'.$date.'"
				');
		$donneeNbPersInscrit = $repNbPersInscrit -> fetch();//$donneeNbPersInscrit = nombre de personne inscrite dans la salle choisis a l'heure choisis a une date choisis
		return $donneeNbPersInscrit['COUNT(cli_id)'];
	}
	
	//--------------------------------------------------------------------------------
	
	function nbPersMax( $salle )// renvoie le nombre de personne maximal autorisé par salle en fonction de la salle
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

	//---------------------------------------------------------------------------------
	
	function empecherDoubleRdv( $date, $heure, $idClient )//vérifie que le client n'a pas deja un rdv soit en salle soit avec un praticien en fonction de la date, l'heure et l'id client
	{
		global $bdd;
		$reponse = $bdd -> query('
				SELECT * 
				FROM PrendRDV 
				WHERE dat_date = "'.$date.'" AND heu_heures = "'.$heure.'" AND cli_id = '.$idClient.'
				');
		
		$reponse2 = $bdd -> query('
				SELECT *
				FROM Crenaux
				WHERE dat_date = "'.$date.'" AND heu_heures = "'.$heure.'" AND cli_id = '.$idClient.'
				');
		
		if( $donnee = $reponse -> fetch() || $donnee2 = $reponse2 -> fetch() )
			return false;
		else
			return true;
	}
	
	
	//---------------------------------------------------------------------------------
	
	function ajouterDate( $date )// Ajoute une date dans la base si elle n'existe pas
	{
		global $bdd;
		$reponse = $bdd -> query('
					SELECT * FROM Date WHERE dat_date = "'.$date.'"
				');
		if( $donnee = $reponse -> fetch() )
			return true;
		else
		{
			$ajouter = $bdd -> query('
					INSERT INTO Date (dat_date)
					VALUE("'.$date.'");
					');
		}
	}

	//---------------------------------------------------------------------------------

	function verifierJourFermeture( $date, $salle ) //Vérifie si le jour a afficher, la salle en question est ouverte
	//Une salle peut etre fermé ou le jour est un dimanche ou le cabinet est entierement fermé pour raison X
	{
		global $bdd;
		$reponse = $bdd -> query('
					SELECT * FROM DispoSalle
					WHERE sal_id = "'.$salle.'" AND dat_date = "'.$date.'"
				');
		if( $donnee = $reponse -> fetch() )
			return true;
		else
			return false;
	}
	
	
