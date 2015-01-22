<?php           
require_once 'includes/form_functions.inc.php';

  if (isset($_POST['submit']) ) {
      $errors = array();  // initialize an array to hold our errors   
      $required_fields = array('conference', 'division', 'Player_name', 'image', 'school');  // perform validation for required fields
      $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

      if (isset($_POST['conference'], $_POST['division'], $_POST['Player_name'], $_POST['image'], $_POST['school'])) {
          $conference_textNode = trim($_POST['conference']);
          $division_textNode = trim($_POST['division']);
          $player_textNode = trim($_POST['Player_name']);
          $image_textNode = trim($_POST['image']);
          $school_textNode = trim($_POST['school']);
      }

      // VALIDATING IMAGE FILE
      // MAKE IMAGE VARIABLES AVAILABLE AND GET ALL THE OTHER INFORMATION FROM THE FORM
      $img_name = trim($_FILES['image']['name']);
      $img_temp_name = $_FILES["image"]["tmp_name"];
      $img_type = $_FILES["image"]["type"];
      $img_size = number_format($_FILES["image"]["size"] / 1024, 1) . ' kb'; // convert the image size to kb
      $img_path = UPLOAD_DIR . $img_name;
      $img_max_size = number_format(MAX_FILE_SIZE / 1024, 1) . ' KB';  // convert the max size to kb

      // Create an array of permitted MIME types
      $permitted_type = array('image/gif', 'image/jpeg', 'image/png');

      // Get image extension
      $img_extension = substr($img_name, strrpos($img_name, '.') + 1);

      // Check that everything is ok with the image file
      // check if a file of the same name has been uploaded in the same directory
      if (in_array($img_type, $permitted_type)
          && !file_exists(UPLOAD_DIR . $img_name)  // check the file is not empty
          && $img_size > 0                         // check the file dont exceed the max size permitted
          && $img_size <= MAX_FILE_SIZE
          && !check_required_fields($required_fields, $_POST)
      ) {
          // If img ok, store it con the defined directory using move_uploaded_file(). IF DESIRED, RANAME
          // IT(see rename() on www.php.net)
          // move_uploaded_file() moves the uploaded file from its temporary location to its permanent one.
          // It will return false if $imageName  is not a valid upload file or if it cannot be moved for any other reason.
          move_uploaded_file($img_temp_name, UPLOAD_DIR . $img_name);

      } else {
          // Oherwise, display img errors using switch() and $_FILES error array.   
          // switch ($_FILES['image']['error']) {   
          switch ($img_name) {
              case(file_exists(UPLOAD_DIR . $img_name)):
                  $errors[] = "$img_name already exists.<br/> Choose a different image or change the name of the image you are  trying to upload";
                  break;
              // check that file is of a permitted MIME type
              case(!in_array($img_type, $permitted_type)):
                  $errors[] = "$img_extension is not a valid file type. <br/> Acceptable image formats include: GIF, PJPEG, JPG/JPEG, and PNG.";
                  break;
              case(empty($_POST['image'])):
                  $errors[] = "You cant upload an image alone. It has to be related to post. Please, sumbit a post.";
                  break;
              //There are 8 possible errors that we can get back:
              // http://www.php.net/manual/en/features.file-upload.errors.php
              case($img_name == UPLOAD_ERR_NO_FILE):
                  $errors[] = "You didn't select a file to be uploaded.";
                  break;
              //Because switch will keep running code until it finds a break, it's
              //easy enough to take the concept of fallthrough and run the same
              //code for more than one case.
              case($img_name == UPLOAD_ERR_INI_SIZE):
              case($img_name == UPLOAD_ERR_FORM_SIZE):
                  $errors[] = "$img_name is either too big or not a valid file.";
                  break;
              default:
                  $errors[] = "Error uploading file. Please try again.";
                  break;
          }
      }

      if (empty($errors)) {
          $dom = new DOMDocument();
          $dom->load('Projet.xml', LIBXML_NOBLANKS);
          $dom->formatOutput = true;

          if ($_POST['name'] == "Memphis Grizzlies") {
              $conferences = $dom->getElementsByTagName('conference');
              //var_dump($conferences);
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');

                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      //var_dump($team);
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;


                          if ($name == "Memphis Grizzlies") {
                              //$roster = $t->roster->player->getElementsByTagName('Player_name')->item(0);
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                                if ($_POST['Player_name'] != $p) {
                                    $root_element = $t->getElementsByTagName("roster")->item(0);
                                    $player_node = $dom->createElement('player');

                                    $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                    $player_node->setAttributeNode($attr_player_jersey);

                                    $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                    $player_node->appendChild($child_node_Player_name);

                                    $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                    $player_node->appendChild($child_node_poste);

                                    $child_node_height = $dom->createElement('height', $_POST['height']);
                                    $player_node->appendChild($child_node_height);

                                    $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                    $player_node->appendChild($child_node_weight);

                                    $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                    $player_node->appendChild($child_node_birthday);

                                    $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                    $player_node->appendChild($child_node_years_pro);

                                    $child_node_school = $dom->createElement('school', $_POST['school']);
                                    $player_node->appendChild($child_node_school);

                                    $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                    $player_node->appendChild($child_node_image);

                                    $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                    $player_node->appendChild($child_node_infos);

                                    $root_element->appendChild($player_node);
                                }
                          }
                      }
                  }
              }
          }

        if ($_POST['name'] == "New Orleans Hornets") {
            $conferences = $dom->getElementsByTagName('conference');
            foreach ($conferences as $conf) {
                $divisions = $conf->getElementsByTagName('division');
                //var_dump($divisions->item(0));
                foreach ($divisions as $div) {
                    $team = $div->getElementsByTagName('team');
                    foreach ($team as $t) {
                        $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                        if ($name == "New Orleans Hornets") {
                            $roster = $t->getElementsByTagName('roster');
                            foreach ($roster as $r) {
                                $player = $r->getElementsByTagName('player');

                                foreach ($player as $p) {
                                    $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                    
                                    if ($_POST['Player_name'] == $p) {
                                        ?>
                                        <script type="text/javascript">
                                            alert("Attention!!! Ce joueur existe deja");
                                        </script>
                                        <?php
                                        break;
                                    }
                                }
                            }

                            if ($_POST['Player_name'] != $p) {
                                $root_element = $t->getElementsByTagName("roster")->item(0);

                                $player_node = $dom->createElement('player');

                                $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                $player_node->setAttributeNode($attr_player_jersey);

                                $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                $player_node->appendChild($child_node_Player_name);

                                $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                $player_node->appendChild($child_node_poste);

                                $child_node_height = $dom->createElement('height', $_POST['height']);
                                $player_node->appendChild($child_node_height);

                                $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                $player_node->appendChild($child_node_weight);

                                $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                $player_node->appendChild($child_node_birthday);

                                $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                $player_node->appendChild($child_node_years_pro);

                                $child_node_school = $dom->createElement('school', $_POST['school']);
                                $player_node->appendChild($child_node_school);

                                $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                $player_node->appendChild($child_node_image);

                                $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                $player_node->appendChild($child_node_infos);

                                $root_element->appendChild($player_node);
                            }
                        }
                    }
                  }
              }
          }

          if ($_POST['name'] == "Houston Rockets") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Houston Rockets") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);

                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "San Antonio Spurs") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "San Antonio Spurs") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {

                                  $root_element = $t->getElementsByTagName("roster")->item(0);

                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Dallas Mavericks") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Dallas Mavericks") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {

                                  $root_element = $t->getElementsByTagName("roster")->item(0);

                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Oklahoma City Thunder") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Oklahoma City Thunder") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Portland Trail Blazers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Portland Trail Blazers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Minnesota Timberwolves") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Minnesota Timberwolves") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Denver Nuggets") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Denver Nuggets") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Utah Jazz") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Utah Jazz") {
                              //$roster = $team->getElementsByTagName("roster");
                              $root_element = $t->getElementsByTagName("roster")->item(0);
                              //echo $root_element->nodeName . "<br />";
                              //$root = $root_element->createElement('roster');
                              $player_node = $dom->createElement('player');

                              $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                              $player_node->setAttributeNode($attr_player_jersey);

                              $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                              $player_node->appendChild($child_node_Player_name);

                              $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                              $player_node->appendChild($child_node_poste);

                              $child_node_height = $dom->createElement('height', $_POST['height']);
                              $player_node->appendChild($child_node_height);

                              $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                              $player_node->appendChild($child_node_weight);

                              $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                              $player_node->appendChild($child_node_birthday);

                              $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                              $player_node->appendChild($child_node_years_pro);

                              $child_node_school = $dom->createElement('school', $_POST['school']);
                              $player_node->appendChild($child_node_school);

                              $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                              $player_node->appendChild($child_node_image);

                              $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                              $player_node->appendChild($child_node_infos);

                              $root_element->appendChild($player_node);
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Los Angeles Lakers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Los Angeles Lakers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Los Angeles Clippers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Los Angeles Clippers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Golden State Warriors") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Golden State Warriors") {
                              //$roster = $team->getElementsByTagName("roster");
                              $root_element = $t->getElementsByTagName("roster")->item(0);
                              //echo $root_element->nodeName . "<br />";
                              //$root = $root_element->createElement('roster');
                              $player_node = $dom->createElement('player');

                              $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                              $player_node->setAttributeNode($attr_player_jersey);

                              $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                              $player_node->appendChild($child_node_Player_name);

                              $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                              $player_node->appendChild($child_node_poste);

                              $child_node_height = $dom->createElement('height', $_POST['height']);
                              $player_node->appendChild($child_node_height);

                              $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                              $player_node->appendChild($child_node_weight);

                              $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                              $player_node->appendChild($child_node_birthday);

                              $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                              $player_node->appendChild($child_node_years_pro);

                              $child_node_school = $dom->createElement('school', $_POST['school']);
                              $player_node->appendChild($child_node_school);

                              $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                              $player_node->appendChild($child_node_image);

                              $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                              $player_node->appendChild($child_node_infos);

                              $root_element->appendChild($player_node);
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Phoenix Suns") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Phoenix Suns") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Sacramento Kings") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Sacramento Kings") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Boston Celtics") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Boston Celtics") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Brooklyn Nets") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Brooklyn Nets") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Los Angeles Lakers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Los Angeles Lakers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "New York Knicks") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "New York Knicks") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Philadelphia 76ers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Philadelphia 76ers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Toronto Raptors") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Toronto Raptors") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Chicago Bulls") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Chicago Bulls") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Cleveland Cavaliers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Cleveland Cavaliers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Detroit Pistons") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Detroit Pistons") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Indiana Pacers") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Indiana Pacers") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Milwaukee Bucks") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Milwaukee Bucks") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Miami Heat") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Miami Heat") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Atlanta Hawks") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Atlanta Hawks") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Charlotte Bobcats") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Charlotte Bobcats") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Orlando Magic") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Orlando Magic") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          if ($_POST['name'] == "Washington Wizards") {
              $conferences = $dom->getElementsByTagName('conference');
              foreach ($conferences as $conf) {
                  $divisions = $conf->getElementsByTagName('division');
                  //var_dump($divisions->item(0));
                  foreach ($divisions as $div) {
                      $team = $div->getElementsByTagName('team');
                      foreach ($team as $t) {
                          $name = $t->getElementsByTagName('name')->item(0)->nodeValue;
                          if ($name == "Washington Wizards") {
                              $roster = $t->getElementsByTagName('roster');
                              foreach ($roster as $r) {
                                  $player = $r->getElementsByTagName('player');

                                  foreach ($player as $p) {
                                      $p = $p->getElementsByTagName('Player_name')->item(0)->nodeValue;
                                      
                                      if ($_POST['Player_name'] == $p) {
                                          ?>
                                          <script type="text/javascript">
                                              alert("Attention!!! Ce joueur existe deja");
                                          </script>
                                          <?php
                                          break;
                                      }
                                  }
                              }

                              if ($_POST['Player_name'] != $p) {
                                  //$roster = $team->getElementsByTagName("roster");
                                  $root_element = $t->getElementsByTagName("roster")->item(0);
                                  //echo $root_element->nodeName . "<br />";
                                  //$root = $root_element->createElement('roster');
                                  $player_node = $dom->createElement('player');

                                  $attr_player_jersey = new DOMAttr('jersey', $_POST['jersey']);
                                  $player_node->setAttributeNode($attr_player_jersey);

                                  $child_node_Player_name = $dom->createElement('Player_name', $_POST['Player_name']);
                                  $player_node->appendChild($child_node_Player_name);

                                  $child_node_poste = $dom->createElement('poste', $_POST['poste']);
                                  $player_node->appendChild($child_node_poste);

                                  $child_node_height = $dom->createElement('height', $_POST['height']);
                                  $player_node->appendChild($child_node_height);

                                  $child_node_weight = $dom->createElement('weight', $_POST['weight']);
                                  $player_node->appendChild($child_node_weight);

                                  $child_node_birthday = $dom->createElement('birthday', $_POST['birthday']);
                                  $player_node->appendChild($child_node_birthday);

                                  $child_node_years_pro = $dom->createElement('years_pro', $_POST['years_pro']);
                                  $player_node->appendChild($child_node_years_pro);

                                  $child_node_school = $dom->createElement('school', $_POST['school']);
                                  $player_node->appendChild($child_node_school);

                                  $child_node_image = $dom->createElement('image', trim($_FILES['image']['name']));
                                  $player_node->appendChild($child_node_image);

                                  $child_node_infos = $dom->createElement('infos', $_POST['infos']);
                                  $player_node->appendChild($child_node_infos);

                                  $root_element->appendChild($player_node);
                              }
                          }
                      }
                  }
              }
          }

          //$dom->appendChild($root);
          # save changes to XML file
          if ($dom->save("Projet.xml") != FALSE) {
              # if save was successful, redirect user to main page.
              //header('Location: add-new-player.php');
              echo "<div class='res'>ENREGISTREMENT DU NOUVEAU JOUEUR EFFECTUÉE AVEC SUCCES!!!</div> "  ;           //exit;
          } else {
              echo 'An error occured.';
          }

      } // end of if  POST submit
  }

?>  
<script src="jquery.js"></script>
<script>
$("res").hide();
$("btn").click({
  $("res").show();
});


</script>