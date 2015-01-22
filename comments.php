<?php
//Récupérer les params
$name = $_POST['nom'];
$txt = $_POST['msg'];


//Ouverture du fichier
$xml = new DomDocument;
$xml->load("coms.xml");

//Ajout nouveau commentaire
$nouveauCom = $xml->createElement("com");
$nouveauCom->setAttribute("nom", $name);
$nouveauCom->setAttribute("msg", $txt);
$coms = $xml->getElementsByTagName("coms")->item(0);
$coms->appendChild($nouveauCom);
$xml->save('coms.xml');
//$chaineXML = $xml->saveXML();



//Lecture et affichage XML
	$com = $xml->getElementsByTagName('com');
		foreach($com as $com){
		$nom = $com->getAttribute("nom");
		$msg = $com->getAttribute('msg');
			for ($i=0; $i <1 ; $i++) { 
				$pseudos[]=$nom;
				$textes[]=$msg;
				}
		}

//Afficher seulement le dernier commentaire
$fin= count($pseudos);
$debut=$fin - 1;


for ($i=$debut ; $i < $fin; $i++) { 
	echo "<span class='d_com'><span class='d_pseudo'>".$pseudos[$i]." :</span></br><span class='d_mes'>".$textes[$i]."</span></span></br>";
}
?>
