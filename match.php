<?php 
          //L'admin pourra generer le MOTD en cliquant sur une div de class gen depuis n'importe quel fichier


          //Ouverture du fichier
          $xml = new DomDocument;
          $xml->load("match.xml");

         
          //Fonction random pour les scores
          $score1=mt_rand(80, 120);
          $score2=mt_rand(80, 120);
          while ($score2 == $score1) {

            $score2=mt_rand(80, 120);
          }
          //Fonction random pour générer les equipes
          $t1=mt_rand(1,30);
          $t2=mt_rand(1,30);
          while ($t2 == $t1) {

            $t2=mt_rand(0,30);
          }
          
          //Ajout des variables de match
          
          $nouveaumatch = $xml->createElement("match");
          $nouveaumatch->setAttribute("equipe1", $t1);
          $nouveaumatch->setAttribute("equipe2", $t2);
          $nouveaumatch->setAttribute("score1", $score1);
          $nouveaumatch->setAttribute("score2", $score2);
          $coms = $xml->getElementsByTagName("matchs")->item(0);
          $coms->appendChild($nouveaumatch);
          $xml->save('match.xml');

        ?>