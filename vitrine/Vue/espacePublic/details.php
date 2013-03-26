<?php 
	require_once('../../Modele/espacePublic/detailCabinet.php');
	$cabinet = detailCabinet($_REQUEST['cab']);// récupère les details du cabinet
	foreach( $cabinet AS $cab )
	{
	}
?>
<body>
	<div class="container">
		<h3 align="center">Cabinet Osteo <?php echo $cab['cab_nom'];?></h3>
		<div class="alert alert-info">
	   		<table class="table">
				<tr>
					<td>
						<img src="../../Vue/images/cabinet/<?php echo $cab['cab_nom'];?>.jpg" width="300" class="img-polaroid">
					</td>
					<td>
						<h5>Cabinet Osteo <?php echo $cab['cab_nom'];?></h5>
						<p><?php echo $cab['cab_adresse1'];?></p>
						<?php 
		    				if( $cab['cab_adresse2'] != NULL )
		    					echo '<p>'.$cab['cab_adresse2'].'</p>';
		    			?>
		    			<p><?php echo $cab['cab_cp'].' '.$cab['cab_ville'];?></p>
		    			<p>tel : <?php echo $cab['cab_tel'];?></p>
		    			</p>Fax : <?php echo $cab['cab_fax'];?></p>
		    			</p>Mail : <?php echo $cab['cab_mail'];?></p>
		    			<?php 
		    				switch( $_REQUEST['cab'] )
		    				{
		    					case "blanquefort" : echo'<p><a href="http://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=1,+Rue+du+Languedoc,+33290,+Blanquefort&amp;aq=&amp;sll=46.22475,2.0517&amp;sspn=21.375295,57.919922&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=1+Rue+de+Languedoc,+33290+Blanquefort,+Gironde,+Aquitaine&amp;z=14&amp;ll=44.909493,-0.624197" target = "blank">Voir le plan</a></small></p>'; break;
		    					case "labrit" : echo'<p><a href="http://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=Route+de+Sabres,+Labrit&amp;aq=0&amp;oq=Route+de+Sabres,&amp;sll=46.22475,2.0517&amp;sspn=21.375295,55.898438&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=Route+de+Sabres,+40420+Labrit,+Landes,+Aquitaine&amp;z=14&amp;ll=44.108201,-0.562117" target = "blank">Voir le plan</a></small></p>'; break;
		    					case "biscarosse" : echo'<p><a href="http://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=5+Rue+Jules+Ferry,+Biscarrosse&amp;aq=0&amp;oq=5,+Rue+Jules+Ferry,+bis&amp;sll=44.108201,-0.562117&amp;sspn=0.021662,0.054588&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=5+Rue+Jules+Ferry,+40600+Biscarrosse,+Landes,+Aquitaine&amp;z=14&amp;ll=44.395138,-1.166299"target = "blank">Voir le plan</a></small></p>'; break;
		    				}
		    			?>
					</td>
					<td>
						<h5>Les horaires : </h5>
						<p>Lundi : 8h -> 12h, 13h -> 18h</p>
						<p>Mardi : 8h -> 12h, 13h -> 18h</p>
						<p>Mercredi : 8h -> 12h, 13h -> 18h</p>
						<p>Jeudi : 8h -> 12h, 13h -> 18h</p>
						<p>Vendredi : 8h -> 12h, 13h -> 18h</p>
						<p>Samedi : 8h -> 12h, 13h -> 18h</p>
					</td>
				</tr>
			</table>
		</div>
		<h3>Nos praticiens : </h3>
	    <table class="table table-striped">
		    <?php 
			    $praticien = detailPraticien($_REQUEST['cab']);
			    foreach( $praticien AS $pra )
			    {
			    	echo'<tr><td><img src="../../Vue/images/praticien/'.$pra['pra_nom'].'.jpg" width="100" class="img-polaroid"></td>
						<td>
							<p>'.$pra['pra_nom'].' '.$pra['pra_prenom'].'</p>';
			    	switch( $pra['pra_grade'] )
			    	{
			    		case 1 : echo'<p>Directeur</p>
									  <p>Responsable de cabinet</p>'		
			    		; break;
			    		case 2 : echo'<p>Responsable de cabinet</p>';
			    	}
						echo '</td></tr>';
			    }	
		    ?>
    	</table>
	</div>
</body>