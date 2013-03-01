<?php 
	require_once'../../Controlleur/conf/connexionBDD.php';
	function supprimerCrenauxPraticien( $id )//Supprime un crénaux praticien en fonction de son identifiant
	{
		global $bdd;
		$reponse = $bdd -> query('
				DELETE FROM Crenaux WHERE cre_id='.$id.'
				');
		return $reponse;
	}
?>