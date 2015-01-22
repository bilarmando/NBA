<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8"> 
  <title>Contactez nous</title>
  <!-- CSS du design-->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/contact.css">

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

<?php
/*
  ********************************************************************************************
  CONFIGURATION
  ********************************************************************************************
*/
// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
$destinataire = 'romaricboss@gmail.com';

// copie ? (envoie une copie au visiteur)
$copie = 'oui';

// Action du formulaire (si votre page a des paramètres dans l'URL)
// si cette page est index.php?page=contact alors mettez index.php?page=contact
// sinon, laissez vide
$form_action = 'contact.php';

// Messages de confirmation du mail
$message_envoye = "Votre message nous est bien parvenu !";
$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

// Message d'erreur du formulaire
$message_formulaire_invalide = "<span class='check_form'>Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.</span>";

/*
  ********************************************************************************************
  FIN DE LA CONFIGURATION
  ********************************************************************************************
*/
/*
Note : Il faudra configurer le serveur local avec les paramatres smtp du serveur de messagerie
*/
/*
 * cette fonction sert à nettoyer et enregistrer un texte
 */
function Rec($text)
{
  $text = htmlspecialchars(trim($text), ENT_QUOTES);
  if (1 === get_magic_quotes_gpc())
  {
    $text = stripslashes($text);
  }

  $text = nl2br($text);
  return $text;
};

/*
 * Cette fonction sert à vérifier la syntaxe d'un email
 */
function IsEmail($email)
{
  $value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
  return (($value === 0) || ($value === false)) ? false : true;
}

// formulaire envoyé, on récupère tous les champs.
$nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
$objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';

// On va vérifier les variables et l'email ...
$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
$err_formulaire = false; // sert pour remplir le formulaire en cas d'erreur si besoin

if (isset($_POST['envoi']))
{
  if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
  {
    // les 4 variables sont remplies, on génère puis envoie le mail
    $headers  = 'From:'.$nom.' <'.$email.'>' . "\r\n";
    //$headers .= 'Reply-To: '.$email. "\r\n" ;
    //$headers .= 'X-Mailer:PHP/'.phpversion();

    // envoyer une copie au visiteur ?
    if ($copie == 'oui')
    {
      $cible = $destinataire.','.$email;
    }
    else
    {
      $cible = $destinataire;
    };

    // Remplacement de certains caractères spéciaux
    $message = str_replace("&#039;","'",$message);
    $message = str_replace("&#8217;","'",$message);
    $message = str_replace("&quot;",'"',$message);
    $message = str_replace('<br>','',$message);
    $message = str_replace('<br />','',$message);
    $message = str_replace("&lt;","<",$message);
    $message = str_replace("&gt;",">",$message);
    $message = str_replace("&amp;","&",$message);

    // Envoi du mail
    if (mail($cible, $objet, $message, $headers))
    {
      echo '<p>'.$message_envoye.'</p>';
    }
    else
    {
      echo '<p>'.$message_non_envoye.'</p>';
    };
  }
  else
  {
    // une des 3 variables (ou plus) est vide ...
    echo '<p>'.$message_formulaire_invalide.'</p>';
    $err_formulaire = true;
  };
}; // fin du if (!isset($_POST['envoi']))

if (($err_formulaire) || (!isset($_POST['envoi'])))
{
  // afficher le formulaire
  echo '
  <div class="form_contact">
  <span class="titre_contact">Contactez-nous</span>
  <form class="contact" method="post" action="'.$form_action.'">

  <label for="nom">Nom <etoile>*</etoile></br>
  </label><input type="text" id="nom" name="nom" value="'.stripslashes($nom).'" tabindex="1" /></br>
  

  <label for="email">Email <etoile>*</etoile></br>
  </label><input type="text" id="email" name="email" value="'.stripslashes($email).'" tabindex="2" /></br>



  <label for="objet">Objet <etoile>*</etoile></br>
  </label><input type="text" id="objet" name="objet" value="'.stripslashes($objet).'" tabindex="3" /></br>


  <label for="message">Message <etoile>*</etoile></br>
  </label><textarea id="message" name="message" tabindex="4" cols="30" rows="8">'.stripslashes($message).'</textarea></br>


  <input type="submit" class="envoi" name="envoi" value="Envoyer" />
  </form>
  </br></br>
  </div>
  ';
};
?>
<!--FOOTER-->
<div class="footer">
  <div class="sociaux">
    <div class="social"><a href="http://www.twitter.com"><img src="img/twitter.png"></a></div>
    <div class="social"><a href="http://www.fb.com"><img src="img/fb.png"></a></div>
    <div class="social"><a href="http://www.linkedin.com"><img src="img/in.png"></a></div>
  </div>

</div>
<!--FIN FOOTER-->

</body>
</html>
