<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8"> 
  <title>NBA WORLD</title>
  <!-- CSS du design-->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/comments.css">

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


 

<div id="Timeline">
    <div class="match">
        
        <?php
      //Ouverture du fichier
      $xml = new DomDocument;
      $xml->load("match.xml");

    //Lecture et affichage XML
      $game = $xml->getElementsByTagName('match');
        foreach($game as $com){
        $eq1 = $com->getAttribute("equipe1");
        $eq2 = $com->getAttribute("equipe2");
        $sc1 = $com->getAttribute("score1");
        $sc2 = $com->getAttribute("score2");
          for ($i=0; $i <1 ; $i++) { 
            $equ1[]=$eq1;
            $equ2[]=$eq2;
            $sco1[]=$sc1;
            $sco2[]=$sc2;
            }
        }


               //Récuperer le logo de l'équipe
            function logo($check,&$log){
                        $xml = new DomDocument;
            $xml->load("Projet.xml");

            //Recuperer la conference
            $conf = $xml->getElementsByTagName('conference');

            foreach($conf as $conf){
              //Récupérer la division
              $div = $conf->getElementsByTagName('division');
              foreach($div as $div){
                //Récupérer les équipes
                $team = $div->getElementsByTagName('team');
                foreach($team as $eq){
                  //Récupérer l'id de l'équipe
                  $id=$eq->getAttribute("id");
                  
                  if ($id==$check){
                    //Récupérer le logo
                    $log= $eq->getElementsByTagName('logo') ->item(0);
                      }
                  }
                }
              }
            }

    //Affichage du Match
      $fin= count($equ1);
      $debut=$fin-1;
      for ($i=$debut; $i < $fin; $i++) { 
        //Recup les infos dans projet.xml
        logo($equ1[$i],$logo1);
        logo($equ2[$i],$logo2);


        //Afficher
          echo "<img class='logo1' src='$logo1->nodeValue'>";
          echo "<img class='logo2' src='$logo2->nodeValue'>";
          echo "<span class='score1'>".$sco1[$i]."</span></br>";
          echo "<span class='trait'>-</span>";
          echo "<span class='score2'>".$sco2[$i]."</span></br>";
      }
      ?>

    </div>

      <?php
      //Ouverture du fichier
      $xml = new DomDocument;
      $xml->load("coms.xml");


    //Lecture et affichage XML
      $com = $xml->getElementsByTagName('com');
        foreach($com as $com){
        $nom = $com->getAttribute("nom");
        $mssg = $com->getAttribute('msg');
          for ($i=0; $i <1 ; $i++) { 
            $pseudos[]=$nom;
            $textes[]=$mssg;
            }
        }

    //Affichage des comments
      $fin= count($pseudos);
      echo "<div class='tl'>";

              for ($i=1; $i < $fin; $i++) { 
                echo "<span class='ligne_msg'><span class='pseudo'>".$pseudos[$i]." :</span> <span class='message'>".$textes[$i]."</span></span></br>";}
      echo "</div>";

      ?>
     </div> 

    <div class="form">
          <!--Formulaire comments-->
          <span class="titre_form">Vos réactions</span>
          <span class="msg">
               <form>
               </br>
               Pseudo <span class="star">*</span> :</br></br>
                <input type="text" id="nom" placeholder="Entrez un Pseudo">
                <br></br>
               Votre Commentaire <span class="star">*</span> : <br></br>
                <textarea id="msg" rows="5" cols="30" placeholder="Entrez le message ici"></textarea>
                </br></br>
                <input type="submit" value="Commenter" class="submit">
                </form>
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

<!--JS/JQUERY/AJAX-->
  <script src="jquery.js"></script>
  <script>
    $(function() {
            //Fonction AJAX pour les commentaires
      $(".submit").click(function() {
        
          var name = $("#nom").val();
          var msg = $("#msg").val();
          var dataString = 'nom='+ name + '&msg=' + msg;
          
          if(name=='' || msg=='')
                {
                alert('TOUS LES CHAMPS SONT OBLIGATOIRES');
                }
          else{
                $.ajax({
                type: "POST",
                url: "comments.php",
                data: dataString,
                cache: false,
                success: function(html){
                $(".tl").append(html);
                  }

                });
              }

          return false;

      }); 

    });
  </script>
</body>
</html>
