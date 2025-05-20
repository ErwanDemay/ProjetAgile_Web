
<?php
include_once 'connexionBase.php';

try {


  $conn = connexionPDO();


  $id = $_POST['id'];
  $sql = "SELECT * FROM visiteur WHERE id = :id";
  $requete = $conn->prepare($sql);
  $requete->bindParam(':id', $id, PDO::PARAM_STR);
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