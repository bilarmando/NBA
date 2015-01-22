<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8"> 
  <title>NBA WORLD</title>
  <!-- CSS du design-->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/slider.css">
  <link rel="stylesheet" href="css/section1.css">
  <link rel="stylesheet" href="css/section2.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/apitwitter.css">
  <!-- Fonctions Optionnelles : CSS Pour les effets Hover-->
  <link rel="stylesheet" href="css/rom/style_common.css">
  <link rel="stylesheet" href="css/rom/style.css">


  </head>

<body>

<!-- Pour le bg et les reseaux sociaux -->
<div class="header">
	<div class="textes"><a href="index.php"><span class="texte_blanc">NBA</span><span class="texte_bleu">WORLD</span></a></div>

	<div class="sociaux">
    <div class="social"><a href="http://www.twitter.com"><img src="img/twitter.png"></a></div>
    <div class="social"><a href="http://www.fb.com"><img src="img/fb.png"></a></div>
    <div class="social"><a href="http://www.linkedin.com"><img src="img/in.png"></a></div>
	</div>
</div>

<!-- Pour le logo menu et recherche -->
<div class="header2">
	<div class="menu">
		<ul>
			<li><a href="index.php" class="text">ACCUEIL</a></li>
			<li><a href="nba_team.php" class="text">CONFERENCES</a></li>
			<li><a href="galery.php" class="text">GALERIE</a></li>
			<li><a href="add-new-player.php" class="text"> NOUVEAU JOEUR </a></li>
			<li><a href="contact.php" class="text">CONTACT</a></li>
			<li><a href="motd.php" class="text">   MOTD</a></li>
		</ul>
	</div>
</div>

<!--FIN DU HEADER-->

<!--SLIDER-->
<div id="slider-wrapper">
		<div class="inner-wrapper">
			<input checked type="radio" name="slide" class="control" id="Slide1"/>
				<label for="Slide1" id="s1"></label>
			<input type="radio" name="slide" class="control" id="Slide2"/>
				<label for="Slide2" id="s2"></label>
			<input type="radio" name="slide" class="control" id="Slide3"/>
				<label for="Slide3" id="s3"></label>
			<input type="radio" name="slide" class="control" id="Slide4"/>
				<label for="Slide4" id="s4"></label>
			<div class="overflow-wrapper">
				<a class="slide" href=""><img src="img/1.jpg"/></a>
				<a class="slide" href=""><img src="img/2.jpg"/></a>
				<a class="slide" href=""><img src="img/3.jpg"/></a>
				<a class="slide" href=""><img src="img/4.jpg"/></a>
			</div>
		</div>
	</div>
<!--FIN SLIDER-->

<!--SECTION 1-->
<div class="section1">
<h2>NBA</h2>
<p>
	La National Basketball Association (ou NBA) est la principale ligue de basket-ball nord-américaine créée en 1946 sous le nom de BAA (Basketball Association of America). En 1949, à la suite de la fusion avec la NBL (National Basketball League), la ligue est renommée NBA.
</p>
	
<div class="sec1">
	<div class="img1"></div>
	<a href="https://www.youtube.com/user/NBA"><h4>Compte Youtube</h4></a>
	<p>Vous trouverez ici toutes les dernières videos et meilleures compilations de la NBA.</p>
</div>


<div class="sec2">
	<div class="img2"></div>
	<a href="http://dwyanewade4mvp.com/"><h4>Notre Blog</h4></a>
	<p>Vous trouverez ici toutes les dernières infos de la frachise floridienne de Miami.</p>
</div>


<div class="sec3">
	<div class="img3"></div>
	<a href="galery.php"><h4>Galerie</h4></a>
	<p>Vous trouverez ici toutes les dernières images réalisées par les fans.</p>
</div>


</div>

<!--FIN SECTION 1-->

<!--SECTION 2-->
<div class="section2">
	<div class="carre"></div>
	<div class="main">
                <div class="view view-first">
                    <img src="img/central.jpg" />
                    <div class="mask">
                        <a href="nba_team.php"><h2>DIVISION CENTRAL</h2></a>
                        <p>Chicago Bulls, Detroit Pistons</br></br>
                                    Milwaukee Bucks</br></br>
                        Indiana Pacers, Cleveland Cavaliers</p>

                    </div>
                </div>  
                <div class="view view-first">
                    <img src="img/atl.jpg" />
                    <div class="mask">
                        <a href="nba_team.php"><h2>DIVISION ATLANTIC</h2></a>
                        <p>Boston Celtics, Philadehie 76Sixers</br></br>
                                    New York Knicks</br></br>
                        Brooklyn Nets, Toronto Raptors</p>

                    </div>
                </div>  
                <div class="view view-first">
                    <img src="img/sud-est.jpg" />
                    <div class="mask">
                        <a href="nba_team.php"><h2>DIVISION SOUTHEAST</h2></a>
                        <p>Atlanta Hawks, Charlotte Bobcats</br></br>
                                    Miami heat</br></br>
                        Orlando Magic, Washington Wizards</p>

                    </div>
                </div>  
                <div class="view view-first">
                    <img src="img/pacific.jpg" />
                    <div class="mask">
                        <a href="nba_team.php"><h2>DIVISION PACIFIC</h2></a>
                        <p>Los Angeles Lakers, Los Angeles Clippers</br></br>
                                    Phoenix Suns</br></br>
                        Golden State Warriors, Sacramento Kings</p>

                    </div>
                </div> 
				<div class="view view-first">
                    <img src="img/sud-ouest.jpg" />
                    <div class="mask">
                        <a href="nba_team.php"><h2>DIVISION SOUTHWEST</h2></a>
                        <p>Dallas Mavericks, Houston Rockets</br></br>
                                    New Orleans Pelicans</br></br>
                        San Antonio Spurs, Memphis Grizzlies</p>

                    </div>
                </div>
				<div class="view view-first">
                    <img src="img/nord-ouest.jpg" />
                    <div class="mask">
                        <a href="nba_team.php"><h2>DIVISION NORTHWEST</h2></a>
                        <p>Oklahoma City Thunder, Denver Nuggets</br></br>
                                    Portland Trailblazers</br></br>
                        Minnesota Timberwolves, Utah Jazz</p>

                    </div>
                </div>  
            </div>
</div>

<!--FIN SECTION 2-->
<div class="prefooter">
  <span class="apitwitter">
      <?php

      require_once('TwitterAPIExchange.php');

      /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
      $settings = array(
          'oauth_access_token' => "1234252778-f2WtKImdT4gBbbAqsqeJnLtsev6KjgwlgUclyyY",
          'oauth_access_token_secret' => "kOGrNfCzI4ppBsaTD0yVkh7NW6v7e6ImGU88e0xm0GNFc",
          'consumer_key' => "xq3YH6jIL1hnnvB0u0i2KzS6S",
          'consumer_secret' => "qgvFubFzrChJ67sFSSbNBmaP0FK0sS2QaD5aAUf7Gn5ktAQfBx"
      );

      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $getfield = '?q=@nba&count=3';
      $requestMethod = 'GET';
      $twitter = new TwitterAPIExchange($settings);
      $strJson =  $twitter->setGetfield($getfield)
                   ->buildOauth($url, $requestMethod)
                   ->performRequest();

      $arrTweets = json_decode($strJson,true);

      //var_dump($arrTweets);
    echo "<span class='tr'>Tweets Récents</span></br></br>";
    //Verifier si les données sont présentes
    if ($arrTweets["statuses"]){
      foreach ($arrTweets["statuses"] as $tweet){

        echo "<span class='ligne_tweet'><span>".strtoupper($tweet["user"]["name"]). "</span></br>".$tweet["text"]." </span></br></br> ";
        //echo "Le ".$tweet["created_at"]."</br>";
      }
    }else echo "Verifiez votre connexion internet";
      ?>
  </span>
  
<!--Sondage-->
  <span class="sondage">
    <span id="sondage">
      <h3>Quelle est votre conference préférée?</h3>
        <form>
        OUEST <input type="radio" name="vote" value="0" onclick="getVote(this.value)"><span id="resultat"></span></br>
        EST <input type="radio" name="vote" value="1" onclick="getVote(this.value)">
        </form>
    </span>
    
  </span>

</div>


<!--FOOTER-->
<div class="footer">
	<div class="sociaux">
    <div class="social"><a href="http://www.twitter.com"><img src="img/twitter.png"></a></div>
    <div class="social"><a href="http://www.fb.com"><img src="img/fb.png"></a></div>
    <div class="social"><a href="http://www.linkedin.com"><img src="img/in.png"></a></div>
	</div>

</div>
<!--FIN FOOTER-->

<!--JAVASCRIPT-->
  <script src="jquery.js"></script>

  <script>
function getVote(int) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("resultat").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","exec.php?vote="+int,true);
  xmlhttp.send();
}
  </script>

</body>
</html>
