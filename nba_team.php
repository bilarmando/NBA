<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8"> 
  <title>Conférences</title>
  <!-- CSS du design-->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/nba_team.css">
  <link rel="stylesheet" href="css/shakeit.css">  

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


<!--Corps-->
<!--Lecture du fichier xml et récupération des données en php -->

<?php

$xml = new DomDocument;
$xml->load("Projet.xml");



//Récupérer toutes les équipes

	   $conf = $xml->getElementsByTagName('conference');
	   foreach($conf as $conf){
			$div = $conf->getElementsByTagName('division');
			foreach($div as $divi){
				$team = $divi->getElementsByTagName('team');
				   foreach($team as $equipes){
				   $id=$equipes->getAttribute("id");
				   $equipe = $equipes->getElementsByTagName('name')->item(0);
				   $logo= $equipes->getElementsByTagName('logo')->item(0);
				   //Remplir le tableau TEAMS avec les equipes, de meme pour les logos
				   for ($i=0; $i <1 ; $i++) { 
					   	$teams[]=$equipe->nodeValue;
					   	$logos[]=$logo->nodeValue;
					   }
				
					}
				}
			}
	 ?>


<div class="box1">	
	<h3 class="conf1">Conference Ouest</h3>	   
		<?php
		for($i=0;$i<15;$i++){
		echo "<span class='est'><a class='shakeit' href='squad.php?id=$i'><img class ='logo' src='$logos[$i]'></a></span>";}
		?>
</div>

<div class="box2">
	<h3 class="conf2">Conference Est</h3>	   
		<?php	   
		for($i=15;$i<30;$i++){
		echo "<span class='est'><a class='shakeit' href='squad.php?id=$i'><img class ='logo' src='$logos[$i]'></a></span>";}
		?>
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

});
</script>
</body>
</html>
