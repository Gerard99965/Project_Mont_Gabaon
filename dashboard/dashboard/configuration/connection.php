<?php
  try
  {
  //montgabaon2024.infinityfreeapp.com
  $bdd = new PDO('mysql:host=localhost;dbname=mont_gabaon', 'root', '');
  }
  catch (Exception $e)
  {
  die('Erreur : ' .$e->getMessage());
  
      }
?>
