<head>
<?php  include_once 'add-player-process.php';  ?>
<?php  include_once 'includes/header.php';   ?> 
<title>Ajout d'un nouveau joueur</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/contact.css"> 
<script type="text/javascript">
    function comboInit(thelist)
    {
        theinput = document.getElementById(theinput);
        var idx = thelist.selectedIndex;
        var content = thelist.options[idx].innerHTML;
        if(theinput.value == "")
            theinput.value = content;
    }

    function combo(thelist, theinput)
    {
        theinput = document.getElementById(theinput);
        var idx = thelist.selectedIndex;
        var content = thelist.options[idx].innerHTML;
        theinput.value = content;
    }
</script>

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
$dom = new DomDocument();

$dom->load('Projet.xml');

$dom->formatOutput = true;
?>
</head>
<div class="container">
    <div class="row">
        <div class=" col-sm-10">

        <div class="alert alert-info"><h2>Add a new player</h2></div>
        <!-- Display error msg-->
            <?php if (!empty($message)) {echo '<p class="msg">' . $message . '</p>';} ?>
            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger"><?php  display_errors($errors);  ?></div>
            <?php } ?>

            <!-- enctype="multipart/form-data" attributes givse HTML the power to search the users local disk with the 'Browse' button.-->
            <form action="" method="post" enctype="multipart/form-data" role="form"  class="myform" >
                <!-- PHP abandons the upload if the file is bigger than the stipulated value, avoiding unnecessary delay if the file is too big. -->
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" >

                <p>The fields with the symblo (*) are required</p>

                <div class="control-group">
                    <label>Team (*) :</label>
                    <select name="thelist" onChange="combo(this, 'theinput')" onMouseOut="comboInit(this, 'theinput')" >
                        <option>Memphis Grizzlies</option>
                        <option>New Orleans Hornets</option>
                        <option>Houston Rockets</option>
                        <option>San Antonio Spurs</option>
                        <option>Dallas Mavericks</option>
                        <option>Oklahoma City Thunder</option>
                        <option>Portland Trail Blazers</option>
                        <option>Minnesota Timberwolves</option>
                        <option>Denver Nuggets</option>
                        <option>Utah Jazz</option>
                        <option>Los Angeles Lakers</option>
                        <option>Los Angeles Clippers</option>
                        <option>Golden State Warriors</option>
                        <option>Phoenix Suns</option>
                        <option>Sacramento Kings</option>
                        <option>Boston Celtics</option>
                        <option>Brooklyn Nets</option>
                        <option>New York Knicks</option>
                        <option>Philadelphia 76ers</option>
                        <option>Toronto Raptors</option>
                        <option>Chicago Bulls</option>
                        <option>Cleveland Cavaliers</option>
                        <option>Detroit Pistons</option>
                        <option>Indiana Pacers</option>
                        <option>Milwaukee Bucks</option>
                        <option>Miami Heat</option>
                        <option>Atlanta Hawks</option>
                        <option>Charlotte Bobcats</option>
                        <option>Orlando Magic</option>
                        <option>Washington Wizards</option>
                    </select>
                    <input type="text" name="name" size="55" class="form-control" id="theinput" value="<?php if(isset($_POST['name']) ) {echo $_POST['name']; }?>" />
                </div>

                <div class="control-group">
                    <label>Jersey Player (*) :</label>
                    <input type="text" name="jersey" size="55" class="form-control"  value="<?php if(isset($_POST['jersey']) ) {echo $_POST['jersey']; }?>" />
                </div>

                <div class="control-group">
                    <label>Player name(*) :</label>
                    <input type="text" name="Player_name" size="55" class="form-control"  value="<?php if(isset($_POST['Player_name']) ) {echo $_POST['Player_name']; }?>" />
                </div>

                <div class="control-group">
                    <label>Poste :</label>
                    <input type="text" name="poste" size="55" class="form-control"  value="<?php if(isset($_POST['poste']) ) {echo $_POST['poste']; }?>" />
                </div>

                <div class="control-group">
                    <label>Height :</label>
                    <input type="text" name="height" size="55" class="form-control"  value="<?php if(isset($_POST['height']) ) {echo $_POST['height']; }?>" />
                </div>

                <div class="control-group">
                    <label>Weight :</label>
                    <input type="text" name="weight" size="55" class="form-control"  value="<?php if(isset($_POST['weight']) ) {echo $_POST['weight']; }?>" />
                </div>

                <div class="control-group">
                    <label>Birthday :</label>
                    <input type="text" name="birthday" size="55" class="form-control"  value="<?php if(isset($_POST['birthday']) ) {echo $_POST['birthday']; }?>" />
                </div>

                <div class="control-group">
                    <label>Years_pro :</label>
                    <input type="text" name="years_pro" size="55" class="form-control"  value="<?php if(isset($_POST['years_pro']) ) {echo $_POST['years_pro']; }?>" />
                </div>

                <div class="control-group">
                    <label>School (*) :</label>
                    <input type="text" name="school" size="55" class="form-control"  value="<?php if(isset($_POST['school']) ) {echo $_POST['school']; }?>" />
                </div>

                <!-- There is no image data to enter in the form, since the data in image element will come from the name of the image submited using $_FILES['image']['name']-->
                <div class="control-group">
                    <label>Upload new image (*) :</label>
                    <!-- //the input type, 'file', which takes the file and passes it to the server, in a temporary place. -->
                    <input type="file" name="image" value="<?php if(isset($_POST['image']) ) {echo $_POST['image']; } ?>"  id="image">

                    <span><small>Acceptable image formats: gif, pjpeg, jpg/jpeg, and png.</small></span>
                </div>

                <div class="alert alert-info">
                    <label>This paragraph is optional</label>
                </div>

                <div class="control-group">
                    <label>Additives informations :</label>
                    <textarea class="form-control" rows="7"  name="infos" value=""><?php if(isset($_POST['infos']) ) { echo $_POST['infos']; } ?></textarea>
                </div>

                <input type="submit" name="submit" value="Save" class="btn btn-primary btn-lg"> <br/><br/>
            </form>

        </div>
    </div>
</div>
