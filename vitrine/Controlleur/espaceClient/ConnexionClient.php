<?php
		require_once('../../Modele/espaceClient/connexionClient.php');
		$mdp = md5($_POST['textinput2']);
		//$mdp = $_POST['textinput2'];
		if( Connexion(mysql_escape_string($_POST['textinput1']), mysql_escape_string($mdp)) == false ) // Si aucun client trouvé
		{
				header('location:../../Controlleur/espacePublic/index.php?er=1');
		}
		else // si client trouve, on ouvre une session client;
		{
			$donneeCli = Connexion( mysql_escape_string($_POST['textinput1']), mysql_escape_string($mdp) );// récupère les informations sur le client et rempli les variables session
			session_start();
			$_SESSION['type'] = "client";
			$_SESSION['id'] = $donneeCli['cli_id'];
			$_SESSION['nom'] = $donneeCli['cli_nom'];
			$_SESSION['prenom'] = $donneeCli['cli_prenom'];
			$_SESSION['adresse1'] = $donneeCli['cli_adresse1'];
			$_SESSION['adresse2'] = $donneeCli['cli_adresse2'];
			$_SESSION['cp'] = $donneeCli['cli_cp'];
			$_SESSION['ville'] = $donneeCli['cli_ville'];
			$_SESSION['tel'] = $donneeCli['cli_tel'];
			$_SESSION['mail'] = $donneeCli['cli_mail'];
			$_SESSION['afficher'] = 1;
			header('location:../../Controlleur/espacePublic/index.php?er=0');
		}
