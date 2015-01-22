<?php
//Récupérer le param vote
$vote = $_GET['vote'];

//Récupérer les valeurs du fichier TXT
$filename = "sondage.txt";
$content = file($filename);

//Mettre les vals dans des array
$array = explode("||", $content[0]);
$ouest = $array[0];
$est = $array[1];

if ($vote == 0) {
  $ouest = $ouest + 1;
}
if ($vote == 1) {
  $est = $est + 1;
}

//Mettre tout ca dans le fichier TXT sous forme O || E
$insertvote = $ouest."||".$est;

//Ouvrir en ecriture
$fp = fopen($filename,"w");
fputs($fp,$insertvote);
fclose($fp);
?>


<img src="img/vote.png"	width='<?php echo(100*round($ouest/($est+$ouest),2)); ?>' height='7px'>
		<?php echo(100*round($ouest/($est+$ouest),2)); ?>%
</br>
<img src="img/vote.png"	width='<?php echo(100*round($est/($est+$ouest),2)); ?>'	height='7px'>
		<?php echo(100*round($est/($est+$ouest),2)); ?>%
