<?
	//Permet la connexion à la base de donnée
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=ppeepsi_db1', 'root', '812AJH', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	}
	catch(Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
