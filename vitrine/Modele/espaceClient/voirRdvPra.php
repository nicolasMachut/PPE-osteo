<?php
require_once'../../Controlleur/conf/connexionBDD.php';
	function voirRdvPra ($id)
	{
		$rdv = array();
		global $bdd;
			$reponse = $bdd->query('
				SELECT heu_heures, dat_date, pra_nom, cab_nom, cre_id
				FROM Crenaux 
				INNER JOIN Praticien ON Praticien.pra_id = Crenaux.pra_id
				INNER JOIN Cabinet ON Cabinet.cab_id = Praticien.cab_id
				WHERE cli_id='.$id.'
				ORDER BY dat_date DESC
				');

			while($donnee = $reponse -> fetch())
			{
				$rdv[] = $donnee;
			}
			return $rdv;
	}

