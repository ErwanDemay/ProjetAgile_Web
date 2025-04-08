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

    public function getAllRecettes() {
        try {
            // Préparation de la requête de sélection
            $sql = "SELECT * FROM Recette ORDER BY dateAjout DESC";
            
            $stmt = $this->prepare($sql);
            $stmt->execute();
            
            // Récupération des résultats
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Création des objets Recette
            $recettes = [];
            foreach ($resultats as $resultat) {
                $recette = new Recette(
                    $resultat['id'],
                    $resultat['libelle'],
                    $resultat['description'],
                    $resultat['uneImage'],
                    $resultat['dateAjout'],
                    $resultat['id_Type']
                );
                $recettes[] = $recette;
            }
            
            return $recettes;
        } catch (PDOException $e) {
            // Log de l'erreur
            error_log("Erreur lors de la récupération des recettes : " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupère l'image BLOB d'une recette
     * @param int $id - ID de la recette
     * @return string|null - Données binaires de l'image ou null si non trouvée
     */
    public function getImageRecette($id) {
        try {
            // Préparation de la requête
            $sql = "SELECT uneImage FROM Recette WHERE id = ?";
            
            $stmt = $this->prepare($sql);
            
            // Configurer PDO pour gérer correctement les données BLOB
            $stmt->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            
            $stmt->execute([$id]);
            
            // Récupération du résultat
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Retourner l'image si elle existe
            if ($resultat && isset($resultat['uneImage'])) {
                return $resultat['uneImage'];
            }
            
            return null;
        } catch (PDOException $e) {
            // Log de l'erreur
            error_log("Erreur lors de la récupération de l'image de la recette : " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Supprime une recette de la base de données
     * @param int $id - ID de la recette à supprimer
     * @return bool - True si la suppression est réussie, false sinon
     */
    public function supprimerRecette($id) {
        try {
            // Préparation de la requête de suppression
            $sql = "DELETE FROM Recette WHERE id = ?";
            
            $stmt = $this->prepare($sql);
            
            // Exécution de la requête avec l'ID
            $resultat = $stmt->execute([$id]);
            
            return $resultat;
        } catch (PDOException $e) {
            // Log de l'erreur
            error_log("Erreur lors de la suppression de la recette : " . $e->getMessage());
            return false;
        }
    }
}

?>