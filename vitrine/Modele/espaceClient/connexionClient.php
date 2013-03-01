<?php

	require_once'../../Controlleur/conf/connexionBDD.php';
	function Connexion( $mail, $mdp )//Connexion du client
	{
		global $bdd;
		$reponse = $bdd -> query( 'SELECT * FROM Client WHERE cli_mail="'.$mail.'" AND cli_mdp="'.$mdp.'"' );//Recherche du compte dans la bdd
		if( $donneeCli = $reponse -> fetch() )//Si compte trouvé
			return $donneeCli;//on retourne les infos du client dans un tableaux
		else
			return false;//Sinon on retourne false
	 }
