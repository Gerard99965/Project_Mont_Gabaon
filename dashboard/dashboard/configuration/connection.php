<?php
  try
  {
  //montgabaon2024.infinityfreeapp.com
  $bdd = new PDO('mysql:host=mysql-montgabaon.alwaysdata.net;dbname=montgabaon_dbname', '347452_mont', 'Sofias@1699');
  }
  catch (Exception $e)
  {
  die('Erreur : ' .$e->getMessage());
  
      }
?>
