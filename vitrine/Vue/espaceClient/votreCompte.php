<body>	
	<script type="text/javascript" src="../../Controlleur/conf/calendrier.js"></script>
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../../Controlleur/conf/design.css" />
	<?php
		include'../../Vue/header.php';
	?>
	<div class="container">
	<?php
		if( isset( $_REQUEST['er'] ) )
			codeErreur($_REQUEST['er']);
	
		if( $_SESSION['afficher'] == 1 )
		{ ?>
			<div class="alert alert-info">
				<button onclick="afficher()" type="button" class="close" data-dismiss="alert">&times;</button>
				<h3>Votre Compte</h3>
				<p>Cette page personnelle vous permet de consulter une partie de vos informations personnelles enregistrées par le groupe Osteo lors de vos consultations.</p>
				<p>Vous avez également la possibilité de visionner l'historique de vos rendez-vous avec nos praticiens.</p>
				<p>De plus vous pouvez réserver du temps dans une de nos salles de sport et conserver l'historique de vos réservations.</p>
			</div>
	<?php }

	?>
	
		<ul class="nav nav-pills" id="menu">
		<?php
			foreach( $compte AS $c )
			{
				echo'<li><a href="votreCompte.php?p='.$c['libelle'].'">'.$c['texte'].'</a></li>';
			}
		?>
		</ul>
		<?php
			page($_REQUEST['p'], $compte);
		?>
	</div>		
</body>
	
