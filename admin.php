<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8"> 
  <title>Espace D'administration</title>
  <!-- CSS du design-->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">


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
      <li><a href="gallery.php" class="text">GALERIE</a></li>
      <li><a href="add-new-player.php" class="text"> NOUVEAU JOEUR </a></li>
      <li><a href="contact.php" class="text">CONTACT</a></li>
      <li><a href="motd.php" class="text">   MOTD</a></li>
    </ul>
  </div>
</div>

<!--FIN DU HEADER-->

<div class="gen">Changer le MOTD
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


<!--JS/JQUERY/AJAX-->
  <script src="jquery.js"></script>
  <script>
    $(function() {
        //Fonction ajax pour générer le match
        $(".gen").click(function() {
          $(".gen").hide();
          $.ajax({
          type: "GET",
          url: "match.php",
          cache: false,
          success: function(html){
          $(".match").append(html);
            }

          });
          });

    });
  </script>
</body>
</html>
