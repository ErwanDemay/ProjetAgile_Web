<?php
include_once 'connexionBase.php';

try {
  $conn = connexionPDO();
  $id = $_POST['id'];
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $login = $_POST['login'];
  $mdp = $_POST['mdp'];
  $adresse = $_POST['adresse'];
  $cp = $_POST['cp'];
  $ville = $_POST['ville'];
  $dateEmbauche = $_POST['dateEmbauche'];


  
  $sql = 'UPDATE visiteur SET nom = :nom, prenom = :prenom , login = :login , mdp = :mdp , adresse = :adresse , cp = :cp , ville = :ville , dateEmbauche = :dateEmbauche WHERE id = :id';
  $requete = $conn->prepare($sql);
  $requete->bindParam(':id', $id, PDO::PARAM_STR);
  $requete->bindParam(':nom',$nom, PDO::PARAM_STR);
  $requete->bindParam(':prenom',$prenom, PDO::PARAM_STR);
  $requete->bindParam(':login',$login, PDO::PARAM_STR);
  $requete->bindParam(':mdp',$mdp, PDO::PARAM_STR);
  $requete->bindParam(':adresse',$adresse, PDO::PARAM_STR);
  $requete->bindParam(':cp',$cp, PDO::PARAM_STR);
  $requete->bindParam(':ville',$ville, PDO::PARAM_STR);
  $requete->bindParam(':dateEmbauche',$dateEmbauche, PDO::PARAM_STR);
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);

  if ($requete->execute()) {
    echo json_encode(["success" => true, "message" => "Visiteur modifié avec succès"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de la modification"]);
}


} catch (PDOException $e) {
  print "Erreur dans la connexion à la base de données";
  print $e;
  die();
}



?>