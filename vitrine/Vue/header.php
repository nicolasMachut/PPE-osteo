     <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../../Controlleur/espacePublic/index.php">
            Osteo
          </a>
          <ul class="nav">
          
            <?php
				if( isset($_SESSION['type']) )
				{
					if( $_SESSION['type'] == "client" )
					{
						echo'
						<li class="active">
							<a href="../espaceClient/votreCompte.php?p=info">
								Votre compte
							</a>
						</li>
					';
					}
				}
            ?>
            
             </ul>
         
          <?php 
			if( isset($_SESSION['type']) )
			{
				echo '<ul class="nav pull-right">
						<li><a>'.$_SESSION["nom"].' '.$_SESSION['prenom'].'</a></li>
					</ul>';
				echo '
				<div class="btn-group pull-right">
					<form class="navbar-form pull-right" method="POST" action="../../Controlleur/espaceClient/Deconnexion.php">
						<input class="btn" id="deco" name="deco" type="submit" value="Déconnexion">
					</form>
				</div>';
			}
			else
			{ 
				echo '
				<form class="navbar-form pull-right" method="POST" action="../../Controlleur/espaceClient/ConnexionClient.php">
					<input name="textinput1" id="textinput1" placeholder="Email" class="span2" type="email">
					<input name="textinput2" id="textinput2" placeholder="Password" class="span2" type="password">
					<input type="submit" name="connexion" id="connexion" value="Connexion" class="btn">
				</form>';
			 }	?>
          
        </div>
      </div>
    </div>
