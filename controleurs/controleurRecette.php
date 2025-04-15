<?php
require_once(__DIR__ . "/../modeles/Recette.php");
require_once(__DIR__ . "/../modeles/DAO/RecetteDAO.php");
require_once(__DIR__ . "/../modeles/DAO/SessionDAO.php");

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
                        
                        // Vérifier si un filtre par type est demandé
                        $typeFiltre = null;
                        if (isset($_GET['type']) && !empty($_GET['type'])) {
                            $typeFiltre = filter_var($_GET['type'], FILTER_SANITIZE_NUMBER_INT);
                            $lesRecettes = $recetteDAO->getRecettesByType($typeFiltre);
                        } else {
                            $lesRecettes = $recetteDAO->getAllRecettes();
                        }
                        require_once("./vues/v_recettes.php");
                        
                        // Déterminer quelle vue charger en fonction du rôle de l'utilisateur
                        //if(isset($_SESSION['utilisateurConnecte'])){ 
                        //    $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                        //    if($utilisateurConnecte->getRole() == "admin"){
                        //        require_once("./vues/v_recettesGestion.php");
                        //    } else {
                        //        require_once("./vues/v_recettes.php");
                        //    }
                        //} else {
                        //    
                        //}
                        // Si c'est pour écrire des cochoneries comme ça c'est pas la peine de coder
                        break;

    case 'consultationDetailsRecettes':
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
                        
                        // Récupérer la recette à afficher
                        $laRecette = $recetteDAO->getRecetteById($id);
                        
                        // Vérifier si la recette existe
                        if (!$laRecette) {
                            $_SESSION['erreur'] = "Recette non trouvée.";
                            header('Location: index.php?controleur=recettes&action=consultationRecettes');
                            exit();
                        }
                        
                        // Afficher la vue des détails
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
        $idType = filter_var($_POST['idType'], FILTER_SANITIZE_NUMBER_INT);
        
        // Traitement de l'image
        $imagePath = null;
        if (isset($_FILES['image'])) {
            error_log("Fichier image reçu : " . print_r($_FILES['image'], true));
            
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Définition du dossier de destination
                $uploadDir = 'assets/images/recettes/';
                error_log("Dossier de destination : " . $uploadDir);
                
                // Création du dossier s'il n'existe pas
                if (!file_exists($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        error_log("Erreur lors de la création du dossier : " . $uploadDir);
                        $_SESSION['erreur'] = "Erreur lors de la création du dossier pour les images.";
                        header('Location: index.php?controleur=recettes&action=ajoutRecette');
                        exit();
                    }
                }
                
                // Vérification des permissions du dossier
                if (!is_writable($uploadDir)) {
                    error_log("Le dossier n'est pas accessible en écriture : " . $uploadDir);
                    $_SESSION['erreur'] = "Le dossier des images n'est pas accessible en écriture.";
                    header('Location: index.php?controleur=recettes&action=ajoutRecette');
                    exit();
                }
                
                // Récupération de l'extension du fichier
                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                error_log("Extension du fichier : " . $fileExtension);
                
                // Vérification de l'extension
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array($fileExtension, $allowedExtensions)) {
                    error_log("Extension non autorisée : " . $fileExtension);
                    $_SESSION['erreur'] = "Format d'image non autorisé. Utilisez JPG, JPEG, PNG ou GIF.";
                    header('Location: index.php?controleur=recettes&action=ajoutRecette');
                    exit();
                }
                
                // Génération d'un nom unique pour l'image
                $imageName = uniqid() . '.' . $fileExtension;
                $imagePath = $uploadDir . $imageName;
                error_log("Chemin complet de l'image : " . $imagePath);
                
                // Déplacement de l'image
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    error_log("Erreur lors du déplacement du fichier. Erreur PHP : " . error_get_last()['message']);
                    $_SESSION['erreur'] = "Erreur lors du téléchargement de l'image.";
                    header('Location: index.php?controleur=recettes&action=ajoutRecette');
                    exit();
                }
                
                error_log("Image téléchargée avec succès : " . $imagePath);
            } else {
                error_log("Erreur lors de l'upload : " . $_FILES['image']['error']);
                $_SESSION['erreur'] = "Erreur lors du téléchargement de l'image. Code d'erreur : " . $_FILES['image']['error'];
                header('Location: index.php?controleur=recettes&action=ajoutRecette');
                exit();
            }
        } else {
            error_log("Aucun fichier image n'a été envoyé");
            $_SESSION['erreur'] = "Aucune image n'a été sélectionnée.";
            header('Location: index.php?controleur=recettes&action=ajoutRecette');
            exit();
        }

        // Appel de la méthode ajoutRecettes avec le chemin de l'image
        error_log("Tentative d'ajout de la recette avec l'image : " . $imagePath);
        $resultat = $recetteDAO->ajoutRecettes($libelle, $description, $imagePath, $idType);
        
        // if ($resultat) {
        //     error_log("Recette ajoutée avec succès");
        //     $_SESSION['message'] = "La recette a été ajoutée avec succès.";
        // } else {
        //     error_log("Échec de l'ajout de la recette");
        //     // En cas d'échec, on supprime l'image uploadée
        //     if (file_exists($imagePath)) {
        //         unlink($imagePath);
        //         error_log("Image supprimée après échec de l'ajout");
        //     }
        //     $_SESSION['erreur'] = "Erreur lors de l'ajout de la recette.";
        // }

        header('Location: index.php?controleur=recettes&action=consultationRecettes');
        exit();

    case 'deleteRecette':
        // Vérifier si l'ID de la recette est fourni
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['erreur'] = "ID de recette non spécifié.";
            header('Location: index.php?controleur=recettes&action=consultationRecettes');
            exit();
        }
        
        // Récupérer l'ID de la recette
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        error_log("Tentative de suppression de la recette avec l'ID : " . $id);
        
        // Créer une instance de RecetteDAO
        $recetteDAO = new RecetteDAO();
        
        // Récupérer la recette pour obtenir le chemin de l'image
        $recette = $recetteDAO->getRecetteById($id);
        
        // Supprimer la recette
        $resultat = $recetteDAO->supprimerRecette($id);
        
        // Gérer le résultat
        // if ($resultat) {
        //     // Succès
        //     $_SESSION['message'] = "La recette a été supprimée avec succès.";
            
        //     // Supprimer l'image si elle existe
        //     if ($recette && $recette->getUneImage() && file_exists($recette->getUneImage())) {
        //         unlink($recette->getUneImage());
        //         error_log("Image supprimée : " . $recette->getUneImage());
        //     }
        // } else {
        //     // Échec
        //     $_SESSION['erreur'] = "Erreur lors de la suppression de la recette.";
        // }
        
        // Rediriger vers la page des recettes
        header('Location: index.php?controleur=recettes&action=consultationRecettes');
        exit();
        
    case 'editRecette':
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
        
        // Récupérer la recette à modifier
        $laRecette = $recetteDAO->getRecetteById($id);
        
        // Vérifier si la recette existe
        if (!$laRecette) {
            $_SESSION['erreur'] = "Recette non trouvée.";
            header('Location: index.php?controleur=recettes&action=consultationRecettes');
            exit();
        }
        
        // Afficher le formulaire de modification
        require_once("./vues/formulaires/v_formulaireModificationRecette.php");
        break;
        
        case 'consultationSessionAssociee':
            if (isset($_GET['idRecette']) && !empty($_GET['idRecette'])) {
                $idRecette = filter_var($_GET['idRecette'], FILTER_SANITIZE_NUMBER_INT);
                
                $sessionDAO = new SessionDAO();
                $recetteDAO = new RecetteDAO();
        
                $laRecette = $recetteDAO->getRecetteById($idRecette); // Pour afficher le titre par exemple
        
                if ($laRecette) {
                    $lesSessionsAssociees = $sessionDAO->getSessionsByRecette($idRecette);
        
                    require_once("./vues/v_sessionsAssocieesARecette.php");
                } else {
                    // Recette introuvable
                    $messageErreur = "Recette introuvable.";
                    header('Location: index.php?controleur=recettes&action=consultationRecettes');
                }
            }
            break;
            
    case 'recetteModified':
        // Vérifier si l'ID de la recette est fourni
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            $_SESSION['erreur'] = "ID de recette non spécifié.";
            header('Location: index.php?controleur=recettes&action=consultationRecettes');
            exit();
        }
        
        // Récupérer l'ID de la recette
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Récupération des données du formulaire
        $libelle = filter_var($_POST['libelle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idType = filter_var($_POST['idType'], FILTER_SANITIZE_NUMBER_INT);
        
        // Traitement de l'image
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            error_log("Nouvelle image téléchargée pour la modification");
            
            // Définition du dossier de destination
            $uploadDir = 'assets/images/recettes/';
            
            // Création du dossier s'il n'existe pas
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Récupération de l'extension du fichier
            $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            // Vérification de l'extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                $_SESSION['erreur'] = "Format d'image non autorisé. Utilisez JPG, JPEG, PNG ou GIF.";
                header('Location: index.php?controleur=recettes&action=editRecette&id=' . $id);
                exit();
            }
            
            // Génération d'un nom unique pour l'image
            $imageName = uniqid() . '.' . $fileExtension;
            $imagePath = $uploadDir . $imageName;
            
            // Déplacement de l'image
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $_SESSION['erreur'] = "Erreur lors du téléchargement de l'image.";
                header('Location: index.php?controleur=recettes&action=editRecette&id=' . $id);
                exit();
            }
            
            // Récupérer l'ancienne image pour la supprimer
            $recetteDAO = new RecetteDAO();
            $ancienneRecette = $recetteDAO->getRecetteById($id);
            if ($ancienneRecette && $ancienneRecette->getUneImage() && file_exists($ancienneRecette->getUneImage())) {
                unlink($ancienneRecette->getUneImage());
                error_log("Ancienne image supprimée : " . $ancienneRecette->getUneImage());
            }
        } else {
            // Pas de nouvelle image, conserver l'ancienne
            $recetteDAO = new RecetteDAO();
            $ancienneRecette = $recetteDAO->getRecetteById($id);
            if ($ancienneRecette) {
                $imagePath = $ancienneRecette->getUneImage();
                error_log("Conservation de l'ancienne image : " . $imagePath);
            }
        }
        
        // Créer une instance de RecetteDAO
        $recetteDAO = new RecetteDAO();
        
        // Modifier la recette
        $resultat = $recetteDAO->modifierRecette($id, $libelle, $description, $imagePath, $idType);
        
        // // Gérer le résultat
        // if ($resultat) {
        //     $_SESSION['message'] = "La recette a été modifiée avec succès.";
        // } else {
        //     $_SESSION['erreur'] = "Erreur lors de la modification de la recette.";
            
        //     // En cas d'échec, supprimer la nouvelle image si elle a été uploadée
        //     if ($imagePath && file_exists($imagePath) && $imagePath !== $ancienneRecette->getUneImage()) {
        //         unlink($imagePath);
        //         error_log("Nouvelle image supprimée après échec de la modification");
        //     }
        // }
        
        // Rediriger vers la page des recettes
        header('Location: index.php?controleur=recettes&action=consultationRecettes');
        exit();

    case 'ajoutRecette':
        // Récupération des données du formulaire
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $idType = filter_input(INPUT_POST, 'idType', FILTER_SANITIZE_NUMBER_INT);
        $image = $_FILES['image'];

        // Vérification des données
        if (empty($libelle) || empty($description) || empty($idType)) {
            $_SESSION['erreur'] = "Tous les champs sont obligatoires.";
            header('Location: index.php?controleur=recettes&action=ajoutRecette');
            exit();
        }

        // Traitement de l'image
        $imagePath = null;
        if ($image['error'] === UPLOAD_ERR_OK) {
            // Définition du dossier de destination
            $uploadDir = 'assets/images/recettes/';
            error_log("Dossier de destination : " . $uploadDir);
            
            // Création du dossier s'il n'existe pas
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    error_log("Erreur lors de la création du dossier : " . $uploadDir);
                    $_SESSION['erreur'] = "Erreur lors de la création du dossier pour les images.";
                    header('Location: index.php?controleur=recettes&action=ajoutRecette');
                    exit();
                }
            }
            
            // Vérification des permissions du dossier
            if (!is_writable($uploadDir)) {
                error_log("Le dossier n'est pas accessible en écriture : " . $uploadDir);
                $_SESSION['erreur'] = "Le dossier des images n'est pas accessible en écriture.";
                header('Location: index.php?controleur=recettes&action=ajoutRecette');
                exit();
            }
            
            // Récupération de l'extension du fichier
            $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            error_log("Extension du fichier : " . $fileExtension);
            
            // Vérification de l'extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                error_log("Extension non autorisée : " . $fileExtension);
                $_SESSION['erreur'] = "Format d'image non autorisé. Utilisez JPG, JPEG, PNG ou GIF.";
                header('Location: index.php?controleur=recettes&action=ajoutRecette');
                exit();
            }
            
            // Génération d'un nom unique pour l'image
            $imageName = uniqid() . '.' . $fileExtension;
            $imagePath = $uploadDir . $imageName;
            error_log("Chemin complet de l'image : " . $imagePath);
            
            // Déplacement de l'image
            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                error_log("Erreur lors du déplacement du fichier. Erreur PHP : " . error_get_last()['message']);
                $_SESSION['erreur'] = "Erreur lors du téléchargement de l'image.";
                header('Location: index.php?controleur=recettes&action=ajoutRecette');
                exit();
            }
            
            error_log("Image téléchargée avec succès : " . $imagePath);
        } else {
            error_log("Erreur lors de l'upload : " . $image['error']);
            $_SESSION['erreur'] = "Erreur lors du téléchargement de l'image. Code d'erreur : " . $image['error'];
            header('Location: index.php?controleur=recettes&action=ajoutRecette');
            exit();
        }

        // Créer une instance de RecetteDAO
        $recetteDAO = new RecetteDAO();

        // Appeler la méthode ajoutRecettes avec les bons paramètres
        $resultat = $recetteDAO->ajoutRecettes($libelle, $description, $imagePath, $idType);
        
        // Gérer le résultat
        if ($resultat) {
            // Succès
            $_SESSION['message'] = "La recette a été ajoutée avec succès.";
        } else {
            // Échec
            $_SESSION['erreur'] = "Erreur lors de l'ajout de la recette.";
            
            // En cas d'échec, supprimer l'image uploadée
            if (file_exists($imagePath)) {
                unlink($imagePath);
                error_log("Image supprimée après échec de l'ajout");
            }
        }

        // Rediriger vers la page des recettes
        header('Location: index.php?controleur=recettes&action=consultationRecettes');
        exit();

    }



?>