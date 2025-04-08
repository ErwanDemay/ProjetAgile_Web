<?php
require_once(__DIR__ . "/../modeles/Recette.php");
require_once(__DIR__ . "/../modeles/DAO/RecetteDAO.php");

// Ajout de logs pour le débogage
error_log("Méthode: " . $_SERVER['REQUEST_METHOD']);
error_log("Action: " . ($_GET['action'] ?? 'non spécifiée'));

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
    $action= "consultationRecettes";
}

// Création d'une instance de RecetteDAO
$recetteDAO = new RecetteDAO();

switch ($action){
    case 'consultationRecettes':
                        // Récupération de toutes les recettes
                        $recetteDAO = new RecetteDAO();
                        $lesRecettes = $recetteDAO->getAllRecettes();
                        
                        // Déterminer quelle vue charger en fonction du rôle de l'utilisateur
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                            $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                            if($utilisateurConnecte->getRole() == "admin"){
                                require_once("./vues/v_recettesGestion.php");
                            } else {
                                require_once("./vues/v_recettes.php");
                            }
                        } else {
                            require_once("./vues/v_recettes.php");
                        }
                        break;

    case 'consultationDetailsRecettes':
                        require_once("./vues/v_recettesDetail.php");
                        break;

    case 'addRecette':
                        // Vérification des droits
                        // if(!isset($_SESSION['utilisateurConnecte']) || 
                        //   unserialize($_SESSION['utilisateurConnecte'])->getRole() != "admin") {
                        //     // Rediriger l'utilisateur non-admin
                        //     header('Location: index.php?action=consultationRecettes');
                        //     exit();
                        // }
                        
                        // Affichage du formulaire d'ajout
                        require_once("./vues/formulaires/v_formulaireAjoutRecette.php");
                        break;

    case 'recetteAdded':
        $recetteDAO = new RecetteDAO();

        // Récupération des données du formulaire
        $libelle = filter_var($_POST['libelle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image = $_FILES['image'];
        
        // Vérifier si le champ 'type' existe, sinon utiliser 'idType'
        $type = isset($_POST['type']) ? $_POST['type'] : (isset($_POST['idType']) ? $_POST['idType'] : null);
        
        // Convertir le type en ID si nécessaire (à adapter selon votre logique)
        $idType = $type;
        
        // Créer l'objet Recette
        $laRecette = new Recette(
            null,      
            $libelle,       
            $description,   
            $image['name'], 
            date('Y-m-d'),  
            $idType         
        );

        // Appeler la méthode ajoutRecettes avec les bons paramètres
        $resultat = $recetteDAO->ajoutRecettes($libelle, $description, $image['name'], $idType);
        
        // Gérer le résultat
        if ($resultat) {
            // Succès
            $_SESSION['message'] = "La recette a été ajoutée avec succès.";
        } else {
            // Échec
            $_SESSION['erreur'] = "Erreur lors de l'ajout de la recette.";
        }

        // Rediriger vers la page des recettes
        header('Location: index.php?controleur=recettes&action=consultationRecettes');
        exit();
        break;

    case 'deleteRecette':
        // Vérifier si l'ID de la recette est fourni
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['erreur'] = "ID de recette non spécifié.";
            header('Location: index.php?controleur=recettes&action=consultationRecettes');
            exit();
        }
        
        // Récupérer l'ID de la recette
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Créer une instance de RecetteDAO
        $recetteDAO = new RecetteDAO();
        
        // Supprimer la recette
        $resultat = $recetteDAO->supprimerRecette($id);
        
        // Gérer le résultat
        // if ($resultat) {
        //     // Succès
        //     $_SESSION['message'] = "La recette a été supprimée avec succès.";
        // } else {
        //     // Échec
        //     $_SESSION['erreur'] = "Erreur lors de la suppression de la recette.";
        // }
        
        // Rediriger vers la page des recettes
        header('Location: index.php?controleur=recettes&action=consultationRecettes');
        exit();
        break;
    }



?>