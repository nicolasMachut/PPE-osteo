<?php 
	require_once'../../Modele/espaceClient/supprimerCrenauxPraticien.php';
	if(supprimerCrenauxPraticien($_REQUEST['id']))
	{
		header('location:votreCompte.php?p=rdv&er=3');
	}
	
?>