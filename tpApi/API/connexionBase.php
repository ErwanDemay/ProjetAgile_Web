<?php
function connexionPDO()
{
   $login = "404647";
   $mdp = "Lafatafagoufoulifi64!";
   $bd = "erwandemay_visiteurs";
   $serveur = "mysql-erwandemay.alwaysdata.net";
   
   try {
      $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp);
      return $conn;
   } catch (PDOException $e) {
      print "connexion a la bdd impossible";
      print $e;
      die();
   }
}
