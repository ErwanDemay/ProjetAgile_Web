<?php

// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");
include_once (__DIR__ . "/../Proposer.php");

class ProposerDAO extends Base {

  public function __construct(){
    parent::__construct();
    $this->setConnexionBase();
  }

  /**
   * Ajoute une recette à une session dans la table Proposer
   * @param int $idRecette ID de la recette à ajouter
   * @param int $idSession ID de la session à laquelle ajouter la recette
   * @return bool True si l'ajout a réussi, False sinon
   */
  public function ajouterRecetteASession($idRecette, $idSession) {
    try {
        $sql = "INSERT INTO Proposer (idRecette, idSession) VALUES (:idRecette, :idSession)";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
        $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de l'ajout de la recette à la session : " . $e->getMessage());
        return false;
    }
  }

  /**
   * Supprime une recette d'une session dans la table Proposer
   * @param int $idRecette ID de la recette à supprimer
   * @param int $idSession ID de la session concernée
   * @return bool True si la suppression a réussi, False sinon
   */
  public function supprimerRecetteDeSession($idRecette, $idSession) {
    try {
        $sql = "DELETE FROM Proposer WHERE idRecette = :idRecette AND idSession = :idSession";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
        $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression de la recette de la session : " . $e->getMessage());
        return false;
    }
  }

  /** 
   * Récupère toutes les recettes liées à une session
   * @param int $idSession ID de la session
   * @return array Tableau contenant les recettes liées à la session
   */
  public function getRecettesBySession($idSession) {
    try {
        $sql = "SELECT r.* 
                FROM Recette r 
                JOIN Proposer p ON r.id = p.idRecette 
                WHERE p.idSession = :idSession";
        
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des recettes de la session : " . $e->getMessage());
        return [];
    }
  }
}

?>