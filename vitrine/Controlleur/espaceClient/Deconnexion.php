<?php
	//déconnecte le client
	session_start();
	$_SESSION = array(); //On écrase le tableau
	session_destroy(); //On détruit la session
	header('location:../../index.php'); //On redirige sur la page d'accueil

	
