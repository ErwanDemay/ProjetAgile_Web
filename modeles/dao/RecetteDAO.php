<?php

// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");

class RecetteDAO extends Base {

  public function __construct(){
    parent::__construct();
    $this->setConnexionBase();
  }
    
    /**
     * Ajoute une nouvelle recette dans la base de données
     * @param string $libelle - Nom de la recette
     * @param string $description - Description de la recette
     * @param string $imagePath - Chemin de l'image de la recette
     * @param int $idType - ID du type de recette
     * @return bool - True si l'ajout est réussi, false sinon
     */
    public function ajoutRecettes($libelle, $description, $imagePath, $idType) {
        try {
            error_log("Tentative d'ajout de recette avec les paramètres :");
            error_log("libelle: " . $libelle);
            error_log("description: " . $description);
            error_log("imagePath: " . $imagePath);
            error_log("idType: " . $idType);

            $sql = "INSERT INTO Recette (libelle, description, uneImage, dateAjout, id_Type) 
                    VALUES (:libelle, :description, :image, CURDATE(), :idType)";
            
            $params = array(
                ':libelle' => $libelle,
                ':description' => $description,
                ':image' => $imagePath,
                ':idType' => $idType
            );
            
            $stmt = $this->prepare($sql);
            $result = $stmt->execute($params);
            
            if (!$result) {
                error_log("Erreur PDO lors de l'exécution de la requête : " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la recette : " . $e->getMessage());
            return false;
        }
    }
    


  /**
 * La fonction getAllRecettes récupère toutes les recettes d'une table de base de données, triées par date d'ajout,
 * et les retourne sous forme d'un tableau d'objets Recette.
 * 
 * @return Un tableau d'objets `Recette` est retourné par la fonction `getAllRecettes`. Chaque
 * objet `Recette` représente une recette avec des propriétés telles que id, libelle, description, uneImage,
 * dateAjout, et id_Type. Si une erreur survient pendant la requête à la base de données, un tableau vide est
 * retourné.
 */
    public function getAllRecettes() {
        try {
            $sql = "SELECT * FROM Recette ORDER BY dateAjout DESC";
            
            $stmt = $this->prepare($sql);
            $stmt->execute();
            
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
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
            error_log("Tentative de récupération de l'image de la recette avec l'ID : " . $id);
            
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
                error_log("Image trouvée pour la recette avec l'ID : " . $id);
                return $resultat['uneImage'];
            }
            
            error_log("Aucune image trouvée pour la recette avec l'ID : " . $id);
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
            error_log("Tentative de suppression de la recette avec l'ID : " . $id);
            
            // Préparation de la requête de suppression
            $sql = "DELETE FROM Recette WHERE id = ?";
            
            $stmt = $this->prepare($sql);
            
            // Exécution de la requête avec l'ID
            $resultat = $stmt->execute([$id]);
            
            if (!$resultat) {
                error_log("Erreur PDO lors de la suppression : " . print_r($stmt->errorInfo(), true));
            } else {
                error_log("Recette supprimée avec succès");
            }
            
            return $resultat;
        } catch (PDOException $e) {
            // Log de l'erreur
            error_log("Erreur lors de la suppression de la recette : " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Récupère une recette par son ID
     * @param int $id - ID de la recette à récupérer
     * @return Recette|null - Objet Recette ou null si non trouvé
     */
    public function getRecetteById($id) {
        try {
            error_log("Tentative de récupération de la recette avec l'ID : " . $id);
            
            // Préparation de la requête
            $sql = "SELECT * FROM Recette WHERE id = ?";
            
            $stmt = $this->prepare($sql);
            $stmt->execute([$id]);
            
            // Récupération du résultat
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Création de l'objet Recette si trouvé
            if ($resultat) {
                error_log("Recette trouvée : " . print_r($resultat, true));
                $recette = new Recette(
                    $resultat['id'],
                    $resultat['libelle'],
                    $resultat['description'],
                    $resultat['uneImage'],
                    $resultat['dateAjout'],
                    $resultat['id_Type']
                );
                return $recette;
            }
            
            error_log("Aucune recette trouvée avec l'ID : " . $id);
            return null;
        } catch (PDOException $e) {
            // Log de l'erreur
            error_log("Erreur lors de la récupération de la recette : " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Modifie une recette existante dans la base de données
     * @param int $id - ID de la recette à modifier
     * @param string $libelle - Nouveau nom de la recette
     * @param string $description - Nouvelle description de la recette
     * @param string $image - Nouvelle image de la recette (chemin ou données binaires)
     * @param int $idType - Nouvel ID du type de recette
     * @return bool - True si la modification est réussie, false sinon
     */
    public function modifierRecette($id, $libelle, $description, $image, $idType) {
        try {
            error_log("Tentative de modification de la recette avec l'ID : " . $id);
            error_log("Nouveau libellé : " . $libelle);
            error_log("Nouvelle description : " . $description);
            error_log("Nouvelle image : " . $image);
            error_log("Nouvel ID de type : " . $idType);
            
            // Préparation de la requête de mise à jour
            $sql = "UPDATE Recette SET libelle = ?, description = ?, uneImage = ?, id_Type = ? WHERE id = ?";
            
            $stmt = $this->prepare($sql);
            
            // Exécution de la requête avec les paramètres
            $resultat = $stmt->execute([
                $libelle,
                $description,
                $image,
                $idType,
                $id
            ]);
            
            if (!$resultat) {
                error_log("Erreur PDO lors de la modification : " . print_r($stmt->errorInfo(), true));
            } else {
                error_log("Recette modifiée avec succès");
            }
            
            return $resultat;
        } catch (PDOException $e) {
            // Log de l'erreur
            error_log("Erreur lors de la modification de la recette : " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Récupère toutes les recettes d'un type spécifique
     * @param int $idType - ID du type de recette
     * @return array - Tableau d'objets Recette
     */
    public function getRecettesByType($idType) {
        try {
            error_log("Tentative de récupération des recettes pour le type : " . $idType);
            
            // Préparation de la requête de sélection
            $sql = "SELECT * FROM Recette WHERE id_Type = ? ORDER BY dateAjout DESC";
            
            $stmt = $this->prepare($sql);
            $stmt->execute([$idType]);
            
            // Récupération des résultats
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("Nombre de recettes trouvées : " . count($resultats));
            
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
            error_log("Erreur lors de la récupération des recettes par type : " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les N dernières recettes ajoutées
     * @param int $limit - Nombre de recettes à récupérer
     * @return array - Tableau d'objets Recette
     */
    public function getLastRecettes() {
        try {
            error_log("Tentative de récupération des 3 dernières recettes par ID");
            
            // Préparation de la requête de sélection - tri par ID décroissant
            $sql = "SELECT * FROM Recette ORDER BY id DESC LIMIT 3";
            error_log("Requête SQL : " . $sql);
            
            $stmt = $this->prepare($sql);
            $stmt->execute();
            
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
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
            error_log("Erreur lors de la récupération des recettes : " . $e->getMessage());
            return [];
        }
    }
}

?>