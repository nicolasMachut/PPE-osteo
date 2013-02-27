<?php 
	session_start();
	require_once('../../Modele/espaceClient/supprimerCrenauxSalle.php');
	if(supprimerCrenauxSalle($_SESSION['id'], $_REQUEST['date'], $_REQUEST['heure']))
	{
		header('location:votreCompte.php?p=newRdv&er=3');
	}
