<?php 
	require_once'../../Controlleur/conf/connexionBDD.php';
	function supprimerCrenauxPraticien($id)
	{
		global $bdd;
		$reponse = $bdd -> query('
				DELETE FROM Crenaux WHERE cre_id='.$id.'
				');
		return $reponse;

	}
?>