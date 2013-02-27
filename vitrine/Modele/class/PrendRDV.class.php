<?php

	require_once'../../Controlleur/conf/connexionBDD.php';
	include'../../Controlleur/conf/tableaux.php';
	require_once'../../Controlleur/conf/fonction.php';
	
	class PrendRDV
	{
		public function voirCrenauxDispo($cabNom, $date)
		{
			$dispo = array();
			global $bdd;
			$reponse = $bdd -> query('
				SELECT heu_heures FROM Heure 
				WHERE heu_heures NOT IN (
				SELECT heu_heures 
				FROM PrendRDV 
				INNER JOIN Salle ON Salle.sal_id=PrendRDV.sal_id 
				INNER JOIN Cabinet ON Cabinet.cab_id=Salle.cab_id
				INNER JOIN Date ON Date.dat_date=PrendRDV.dat_date 
				WHERE cab_nom="'.$cabNom.'" AND PrendRDV.dat_date="'.$date.'"
				)
			');

			while($crenauxDispo = $reponse -> fetch())
			{
				$dispo[] = $crenauxDispo;
			}
			return $dispo;
		}
		
	}
