<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8"> 
  <title>SQUAD</title>
  <!-- CSS du design-->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/equipe.css">
  <link rel="stylesheet" href="css/shakeit.css">  

  </head>

<body>
<div
		  class="fb-like"
		  data-share="true"
		  data-width="450"
		  data-show-faces="true">
		</div>
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

<!-- Pour les joueurs -->
<!--Lecture du fichier xml et récupération des données en php -->

<?php
//Recuperer l'id passé dans l'url et l'incrementer car il commence à 0 
$check=$_GET['id']+1;

$xml = new DomDocument;
$xml->load("Projet.xml");

//Recuperer la conference
$conf = $xml->getElementsByTagName('conference');

foreach($conf as $conf){
	//Récupérer la division
	$div = $conf->getElementsByTagName('division');
	foreach($div as $div){
		//Récupérer les équipes
		$nom_div=$div->getAttribute("div_name");
		$team = $div->getElementsByTagName('team');
		foreach($team as $eq){
			//Récupérer l'id de l'équipe
			$id=$eq->getAttribute("id");
			
			if ($id==$check){
				//Récupérer les infos relatives à une équipe
				$nom_e= $eq->getElementsByTagName('name') ->item(0);
				$coach= $eq->getElementsByTagName('coach') ->item(0);
				$proprio= $eq->getElementsByTagName('owner') ->item(0);
				$salle= $eq->getElementsByTagName('salle') ->item(0);
				$ville= $salle->getAttribute('ville');
				$aw= $eq->getElementsByTagName('awards') ->item(0);
				$logo= $eq->getElementsByTagName('logo') ->item(0);
				$nbj= $eq->getElementsByTagName('player_nb') ->item(0);
				//Récupérer le roster
				$players=$eq->getElementsByTagName('player');
				}
		}
	}
}
?>
<!--Recuperer l'id dans un input hidden-->

<input type="hidden" id="foo" name="navigateur" value="<?php echo $check;?>">

<!--Contient la div des infos de joueurs-->
<div class="joueurs">
<?php
foreach($players as $player){
					$nom_j= $player->getElementsByTagName('Player_name') ->item(0);
					$poste= $player->getElementsByTagName('poste') ->item(0);
					$taille= $player->getElementsByTagName('height') ->item(0);
					$poids= $player->getElementsByTagName('weight') ->item(0);
					$anniv= $player->getElementsByTagName('birthday') ->item(0);
					$univ= $player->getElementsByTagName('school') ->item(0);
					$exp= $player->getElementsByTagName('years_pro') ->item(0);

					//Conversion lb ==> kg
					$poids1=$poids->nodeValue*0.453;
					
					
//Afficher les joueurs
echo "<div class='container'>";					
		echo "<div class='pic'><div class='textbox'>";
		echo "<span class='aux'><strong>Poste :</strong> ".$poste->nodeValue."</span>";
		echo "<span class='aux'><strong>Taille :</strong> ".$taille->nodeValue." cm </span>";
		echo "<span class='aux'><strong>DOB :</strong> ".$anniv->nodeValue."</span>";
		echo "<span class='aux'><strong>Poids :</strong> ".$poids1." Kg</span>";					
		echo "<span class='aux'><strong>Provenance :</strong> ".$univ->nodeValue."</span></div>";
		echo "<span class='nom'>".$nom_j->nodeValue."</span></div>";					
echo "</div>";
}
					
?>
</div>


<!--Contient la div des infos d'équipe-->
<div class="equipe">
<div class="box">
<?php
		//Infos de l'equipe
		echo "<div class='titre'><strong>Franchise :</strong> ".$nom_e->nodeValue."</div>";
		echo "<div class='image2'><img src='$logo->nodeValue'></div>";
		echo "<div class='infos'>";
		echo "<span class='aux'><strong>Coach :</strong> ".$coach->nodeValue."</span>";
		echo "<span class='aux'><strong>Propriétaire :</strong> ".$proprio->nodeValue."</span>";
		echo "<span class='aux'><strong>Salle :</strong> ".$salle->nodeValue."</span>";
		echo "<span class='aux'><strong>Titre Nba :</strong> ".$aw->nodeValue."</span>";
		echo "<span class='aux'><strong>Nombre de Joueurs :</strong> ".$nbj->nodeValue."</span></div>";
		
?>
</div>
	<!--div de MAP-->
		<div class="weather">
		<?php

		$options = array( 
					CURLOPT_URL => "http://api.openweathermap.org/data/2.5/weather?q=$ville&mode=json&units=metric&lang=fr",
					CURLOPT_RETURNTRANSFER => true,
				);

		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$strJson = curl_exec($feed);
		curl_close($feed);

		$arrWeatherInfos = json_decode($strJson,true);

		$strWeather = $arrWeatherInfos['weather'][0]['description'];
		$temp = $arrWeatherInfos['main']['temp'];
		$humidite = $arrWeatherInfos['main']['humidity'];
		$num= $arrWeatherInfos['weather'][0]['id'];
		$cloud= $arrWeatherInfos['clouds']['all'];
		$wind = $arrWeatherInfos['wind']['speed'];
		
		/*Logos de Meteo*/
		if ($num=='') $ico="img/meteo/11d.png";
		if ($num>=200 && $num<=232) $ico="img/meteo/11d.png";
		if (($num>=300 && $num<=321) || ($num>=520 && $num<=531)) $ico="img/meteo/09d.png";
		if ($num>=500 && $num<=504) $ico="img/meteo/09d.png";
		if (($num>=600 && $num<=622) || ($num==511)) $ico="img/meteo/13d.png";
		if ($num>=701 && $num<=781) $ico="img/meteo/50d.png";
		if ($num>=800) $ico="img/meteo/01d.png";
		if ($num>=801) $ico="img/meteo/02d.png";
		if ($num>=802) $ico="img/meteo/03d.png";
		if ($num>=803 || $num>=804) $ico="img/meteo/04d.png";


		//Affichage
		
		
		echo "<span class='localisation'><img src=img/meteo/maps.png>".$ville." </span>";
		//Date
		$mydate=getdate();
		echo "<span class='date'><img src=img/meteo/time.png> $mydate[mday]/$mydate[mon]/$mydate[year]</span>";
		echo "<span class='tmp'><img src='$ico'>".$temp." °C</span>";
		//Meteo1
		echo "<div class='meteo1'><span class='description'>".$strWeather."</span>";
		echo "<span><img src=img/meteo/vent.png> ".$wind." km/h</span>";
		echo "<span><img src=img/meteo/nuage.png> ".$cloud." %</span>";
		echo "<span><img src=img/meteo/humidite.png> ".$humidite." %</span></div>";
	?>
		</div>

		<div class="local">
		<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $ville;?>&size=472x300&zoom=15&markers=color:blue|label:U|<?php echo $ville;?>" />
		</div>

		

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


<script src="jquery.js"></script>

<script type="text/javascript">
$(function() {
var $titre = <?php echo $nom_e->nodeValue; ?>;
    $("title").append($titre);
});
</script>
</body>
</html>
