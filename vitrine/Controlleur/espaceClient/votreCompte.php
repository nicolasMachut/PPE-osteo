<?php
	session_start();
	if( isset($_SESSION['type']) AND $_SESSION['type'] == "client" )
	{
		include'../../Vue/head.php';
		include'../conf/tableaux.php';
		require_once'../conf/connexionBDD.php';
		require_once'../conf/fonction.php';
		include'../../Vue/espaceClient/votreCompte.php';
	}
	else
	{
		header('location:../espacePublic/index.php?er=2');
	}
	
	?>
	<script src="../../Vue/assets/js/jquery-1.8.3.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="../../Vue/assets/js/bootstrap.js"></script>
	<script>


	
	function afficher()
	{
		$('<script/>').attr('src','afficher.php').appendTo($('body'));
	}
	</script>