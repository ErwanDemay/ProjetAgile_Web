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

  $sql = "INSERT INTO visiteur (id,nom, prenom,login,mdp, adresse, cp, ville, dateEmbauche) VALUES (:id,:nom, :prenom,:login,:mdp, :adresse, :cp, :ville, :dateEmbauche)";
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

  if ($requete->execute()) {
    echo json_encode(["success" => true, "message" => "Visiteur ajouté avec succès"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'ajout du visiteur"]);
}


} catch (PDOException $e) {
  print "Erreur dans la connexion à la base de données";
  print $e;
  die();
}



?>