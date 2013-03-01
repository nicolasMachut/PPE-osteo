<div class="alert alert-info">
	<p>Si ces informations ont changé ou sont incorrects, contactez votre cabinet pour les modifier.</p>
</div>
<?php
//affiche les infos du client a partir des variables session
	echo'<table class="table table-bordered">';
	echo '<tr><td>'.$_SESSION['nom'].' '.$_SESSION['prenom'].'</td><tr>';
	echo '<tr><td>'.$_SESSION['adresse1'].'</td></tr>';
	if( $_SESSION['adresse2'] != '' )
		echo '<tr><td>'.$_SESSION['adresse2'].'</td></tr>';
	echo '<tr><td>'.$_SESSION['cp'].' '.$_SESSION['ville'].'</td></tr>';
	echo '<tr><td>'.$_SESSION['mail'].'</td></tr>';
	echo '<tr><td>'.$_SESSION['tel'].'</td></tr>';
	echo'</table>';

