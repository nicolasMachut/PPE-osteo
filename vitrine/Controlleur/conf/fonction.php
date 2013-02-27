<?php
require_once'../../Modele/espaceClient/reserverCrenauxSalle.php';

	function convertionDate($maDate)
	{
		$timestamp = strtotime($maDate);
		$afficherDateRdv = date('l', $timestamp);
		switch($afficherDateRdv)
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
		switch($afficherDateRdv)
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


	function page($page, $compte)
	{
		if(isset($_SESSION['type']))
		{
			if($_SESSION['type'] == "client")
			{
				foreach($compte AS $c)
				{
					if($page == $c['libelle'])
					{
						include '../../Vue/espaceClient/'.$c['libelle'].'.php';
					}
				}
			}
		}
	}

	function codeErreur($er)
	{
		switch($er)
		{
			case 0 : 
				echo'
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<p>Vous êtes maintenant connecté, vous pouvez accéder à votre espace personnel
						 en cliquant sur <a href="../espaceClient/votreCompte.php">"Votre Compte"</a>.</p>
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
						<button onclick="afficher()" type="button" class="close" data-dismiss="alert">&times;</button>
						<p>Le crénaux à bien été libéré.</p>
					</div>
						';
				break;
		}
	}
	
	function verifierDelaisSuppression($dateRdv)
	{
		$dateRdv = strtotime($dateRdv);
		$dateDay = strtotime(date('Y-m-d'));
		$diff = $dateRdv - $dateDay;
		$nbHeure = 60 * 60;
		$diff = $diff / $nbHeure;
		if($diff >= 48)
			return true;
		else 
			return false;
	}

	//--------------------------------------------------------------------------------
	
	function voirCrenauxDispo($date, $heure, $salle)
	{
		$nbPersInscrit = nbPersInscrit($date, $heure, $salle);
		$nbPersMax = nbPersMax($salle);
	
		if($nbPersInscrit >= $nbPersMax)// Si le nombre de personne inscrit est supérieur ou égale au nombre de personne max de la salle
			return false;
		else
			return true;
	}
	
	//-------------------------------------------------------------------------------
	
	
	