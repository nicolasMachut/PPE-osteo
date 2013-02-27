
  <body>

    <div class="container">
    	  <?php
		if(isset($_REQUEST['er']))
		{
			codeErreur($_REQUEST['er']);
		}
		
	?>
      <div class="hero-unit">
        <div>
          <h1>
            Le groupe Osteo
          </h1>
          </br>
          <p>
			Le groupe Osteo vous offre un double service. Ses 13 praticiens répartis sur 3 cabinets sont a votre disposition pour tous vos besoins médicaux.
			De plus nous vous proposons l'accès à 8 salles de sport en autonomie ou sous la tutelle de nos praticiens pour travailler tous vos exercices physiques.
          </p>
        </div>
      </div>
      <div class="row">
        <div class="span4">
          <div>
            <h2>
              Blanquefort
            </h2>
            <p>
				Parfaitement situé en plein centre ville près de l'église, le cabinet de Blanquefort est le plus grand du groupe. Il dispose de pas moins de 4 salles de sport et et bénéficie de la présence à plein temps de 6 praticiens expérimentés.
            </p>
          </div>
          <a class="btn" href="details.php?cab=blanquefort">
            Voir les détails »
          </a>
        </div>
        <div class="span4">
          <div>
            <h2>
              Labrit
            </h2>
            <p>
				Situé dans une zone calme, entouré de nature, le cabinet de Labrit vous propose 2 salles de sport et la possibilité de rencontrer 4 praticiens expérimentés.
            </p>
          </div>
			<a class="btn" href="details.php?cab=labrit">
            Voir les détails »
          </a>
        </div>
        <div class="span4">
          <div>
            <h2>
              Biscarrosse
            </h2>
            <p>
				Proche du centre ville, le cabinet de Biscarosse offre toute les comodités au niveau du transport. Il abrite 2 salles de sports et compte 3 praticiens expérimentés.
            </p>
          </div>
          <a class="btn" href="details.php?cab=biscarosse">
            Voir les détails »
          </a>
        </div>
      </div>
      <hr>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="../assets/js/bootstrap.js">
    </script>
  </body>

</html>
