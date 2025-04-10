<?php

// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");
include_once (__DIR__ . "/../Proposer.php");

class ProposerDAO extends Base {

  public function __construct(){
    parent::__construct();
    $this->setConnexionBase();
  }

  // Fonction pour ajouter une recette à une session
public function ajouterRecetteASession($idRecette, $idSession) {
    $sql = "INSERT INTO Proposer (id, id_Session) VALUES (?, ?)";
    $stmt = $this->prepare($sql);
    $stmt->bind_param("ii", $idRecette, $idSession);
    $stmt->execute();
    $stmt->close();
}

}

?>