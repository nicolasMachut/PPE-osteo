<div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="accueil.php">
            Osteo
          </a>
          <ul class="nav" id="headNav">
<?php if(isset($_SESSION["grade"])) { ?>
            <li>
                  <a class="brand" href="client.php">
                    Clients
                  </a>
            </li>
<?php } ?>
<?php if($_SESSION["grade"] == "pra") { ?>
            <li>
                  <a class="brand" href="client.php">
                    Personnels
                  </a>
            </li>
<?php } ?>
          </ul>
<?php if(isset($_SESSION["cab"])) { ?>
          <div class="btn-group pull-right">
                  <form class="navbar-form pull-right" method="POST" action="inc/logout.php">
                          <input class="btn" id="deco" name="deco" type="submit" value="Déconnexion">
                  </form>
          </div>
<?php } ?>
        </div>
      </div>
    </div>