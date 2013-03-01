<?php
	//page appelée grace a ajax dans la page votreCompte.php pour enlever l'affichage du div bleu explicatif a la connexion
	session_start();
	$_SESSION['afficher'] = 0;