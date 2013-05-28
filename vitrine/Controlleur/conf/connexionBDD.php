<?
	//Permet la connexion à la base de donnée
	try
	{
		$bdd = new PDO('mysql:host=sql.franceserv.fr;dbname=ppeepsi_db1', 'ppeepsi', 'epsi2016', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	}
	catch(Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
