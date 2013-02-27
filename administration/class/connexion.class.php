<?php

	class Connexion
	{
		private $login;
		private $password;
		
		public function userConnexion($login, $password)
		{
			global $db;
			$request = $db->query('SELECT * FROM Cabinet WHERE cab_loginSec="'.$login.'" AND cab_mdpSec="'.$password.'"');
			if($donnees = $request->fetch())
			{
				return $donnees;
			}
			else
			{
				return FALSE;
			}
		}
	}