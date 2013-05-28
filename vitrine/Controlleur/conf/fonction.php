<?php
require_once'../../Modele/espaceClient/reserverCrenauxSalle.php';

	function convertionDate( $maDate )// convertie une date au format "Vendredi 23 Mars 2013", en francais
	{
		$timestamp = strtotime($maDate);
		$afficherDateRdv = date('l', $timestamp);
		switch( $afficherDateRdv )
		{
			case "Monday" : $jour = "Lundi"; break;
			case "Tuesday" : $jour = "Mardi"; break;
			case "Wednesday" : $jour = "Mercredi"; break;
			case "Thursday" : $jour = "Jeudi"; break;
			case "Friday" : $jour = "Vendredi"; break;
			case "Saturday" : $jour = "Samedi"; break;
			case "Sunday" : $jour = "Dimanche"; break;
		}
		$afficherDateRdv = date('F', $timestamp);
		switch( $afficherDateRdv )
		{
			case "January": $mois = "Janvier"; break;
			case "February" : $mois = "Février"; break;
			case "March" : $mois = "Mars"; break;
			case "April" : $mois = "Avril"; break;
			case "May" : $mois = "Mai"; break;
			case "June" : $mois = "Juin"; break;
			case "July" : $mois = "Juillet"; break;
			case "August" : $mois = "Août"; break;
			case "September" : $mois = "Septembre"; break;
			case "October" :  $mois = "Octobre"; break;
			case "November" : $mois = "Novembre"; break;
			case "December" : $mois = "Décembre"; break;
		}
		
		$numJour = date('d', $timestamp);
		$annee = date('Y', $timestamp);
		$resultat = $jour . ' ' . $numJour . ' ' . $mois . ' ' . $annee;
		return $resultat;
	}
	
	//--------------------------------------------------------------------------------

	function page( $page, $compte ) //inclut les vues dans Vue/espaceCLient/votreCompte.php
	{
		if( isset( $_SESSION['type'] ) )
		{
			if( $_SESSION['type'] == "client" )
			{
				foreach( $compte AS $c )
				{
					if( $page == $c['libelle'] )
					{
						include '../../Vue/espaceClient/'.$c['libelle'].'.php';
					}
				}
			}
		}
	}

	//--------------------------------------------------------------------------------
	
	function codeErreur( $er )//Liste des différents messages a afficher : succes/erreur/warning
	{
		switch( $er )
		{
			case 0 : 
				echo'
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<p>Vous êtes maintenant connecté, vous pouvez accéder à votre espace personnel
						 en cliquant sur <a href="../espaceClient/votreCompte.php?p=info">"Votre Compte"</a>.</p>
					</div>
					';
			break;
			case 1 : 
				echo'
					<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<p>Aucun compte n\'existe avec cette combinaison mot de passe / courriel. Vous pouvez contacter l\'un des cabinet pour vous créer un compte.</p>
					</div>
				';
			break;
			case 2 : 
				echo'
					<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<p>Vous devez vos authentifier pour accéder à cette page.</p>
					</div>';
			break;
			case 3 : 
				echo'
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<p>Le crénaux à bien été libéré.</p>
					</div>
						';
				break;
		}
	}
	
	//-----------------------------------------------------------------------------
	
	function verifierDelaisSuppression( $dateRdv )//Vérifie lors de la suppression d'un rdv si il est supprimé 48h a l'avance
	{
		$dateRdv = strtotime( $dateRdv );
		$dateDay = strtotime( date('Y-m-d') );
		$diff = $dateRdv - $dateDay;
		$nbHeure = 60 * 60;
		$diff = $diff / $nbHeure;
		if( $diff >= 48 )
			return true;
		else 
			return false;
	}

	//--------------------------------------------------------------------------------
	
	function voirCrenauxDispo( $date, $heure, $salle )//vérifie que le crénaux dans une salle, a une heure et une date n'est pas plein
	{
		$nbPersInscrit = nbPersInscrit( $date, $heure, $salle );
		$nbPersMax = nbPersMax( $salle );
	
		if( $nbPersInscrit >= $nbPersMax )// Si le nombre de personne inscrit est supérieur ou égale au nombre de personne max de la salle
			return false;
		else
			return true;
	}
	
	//-------------------------------------------------------------------------------

	
	function verificationJourOuverture( $date, $salle ) // Verifie que le jour choisis par le client n'est pas un dimanche ou un jour fermé
	{
		if( verifierJourFermeture( $date, $salle ) )
			return false;
		else
		$timestamp = strtotime($date);
		$jour = date('l', $timestamp);
		if( $jour == "Sunday" )
			return false;
		else
			return true;
	}
	//---------------------------------------------------------------------------------
	
	function verifierJourHeureCrenaux( $date, $heure )// verifie le jour et l'heure du crenaux salle par rapport au jour actuel
	{
		$dateDay = date('Y-m-d');
		if($dateDay < $date)
			return true;//Le jour n'est pas passé on peut prendre rdv
		elseif( $dateDay > $date )
			return false;//le jour est passé, impossible de prendre rdv
		elseif( $dateDay == $date )
		{
			$heureNow =  date('H:i:s');
			if( $heureNow > $heure )
				return false; // L'heure est passé on peut donc pas prendre rdv
			else
				return true;// L'heure n'est pas passé, pas de rdv
		}
	}
	
	//---------------------------------------------------------------------------------
	