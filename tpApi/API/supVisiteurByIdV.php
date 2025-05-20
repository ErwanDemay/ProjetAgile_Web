<?php
include_once 'connexionBase.php';

try {
  $conn = connexionPDO();

  $id = $_POST['id'];


  $sql = 'DELETE FROM visiteur WHERE id = :id';
  $requete = $conn->prepare($sql);
  $requete->bindParam(':id', $id, PDO::PARAM_STR);
  $requete->execute();
  
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);

  if ($requete->execute()){
    echo json_encode(["success" => true, "message" => "Visiteur supprimé avec succès"]);
  } else {
    echo json_encode(["success" => false, "message" => "Erreur lors de la suppression"]);
  }
  
} catch (PDOException $e) {
  print "Erreur dans la connexion à la base de données";
  print $e;
  die();
}



?>