<?php

// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");

class RecetteDAO extends Base {

  public function __construct(){
    parent::__construct();
    parent::setConnexionBase();
  }
    
    /**
     * Ajoute une nouvelle recette dans la base de données
     * @param string $libelle - Nom de la recette
     * @param string $description - Description de la recette
     * @param string $image - Image de la recette (chemin ou données binaires)
     * @param int $idType - ID du type de recette
     * @return bool - True si l'ajout est réussi, false sinon
     */
    public function ajoutRecettes($libelle, $description, $image, $idType) {
        try {
            
            // Préparation de la requête d'insertion
            $sql = "INSERT INTO Recette (libelle, description, uneImage, dateAjout, id_Type) 
                    VALUES (?, ?, ?, CURDATE(), ?)";
            
            $stmt = $this->prepare($sql);
            
            // Exécution de la requête avec les paramètres
            $resultat = $stmt->execute([
                $libelle,
                $description,
                $image,
                $idType
            ]);

            return $resultat;
        } catch (PDOException $e) {
            // Log de l'erreur (à implémenter selon vos besoins)
            error_log("Erreur lors de l'ajout de la recette : " . $e->getMessage());
            return false;
        }
    }
}

?>