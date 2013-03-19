<?php 
	//appel la fonction pour supprimer un crénaux salle qui est dans Modele
	echo 'yo';
	session_start();
	require_once('../../Modele/espaceClient/supprimerCrenauxSalle.php');
	supprimerCrenauxSalle($_SESSION['id'], $_REQUEST['date'], $_REQUEST['heure']);
