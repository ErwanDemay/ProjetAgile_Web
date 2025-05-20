<?php
include_once 'connexionBase.php';

try {
  $conn = connexionPDO();

  $login = $_POST['login'];
  $mdp = $_POST['mdp'];


  $sql = "SELECT * FROM visiteur WHERE login = :login AND mdp = :mdp";
  $requete = $conn->prepare($sql);
 
  $requete->bindParam(':login',$login, PDO::PARAM_STR);
  $requete->bindParam(':mdp',$mdp, PDO::PARAM_STR);

  $requete->execute();
  
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  
  // Afficher le résultat en JSON
  echo json_encode($result);
  
} catch (PDOException $e) {
  print "Erreur dans la connexion à la base de données";
  print $e;
  die();
}



?>