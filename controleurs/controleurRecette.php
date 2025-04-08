<?php
require_once(__DIR__ . "/../modeles/Recette.php");
require_once(__DIR__ . "/../modeles/DAO/RecetteDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
    $action= "consultationRecettes";
}

// Création d'une instance de RecetteDAO
$recetteDAO = new RecetteDAO();

switch ($action){
    case 'consultationRecettes'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                          $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                          if($utilisateurConnecte->getRole() == "admin"){
                            require_once("./vues/v_recettesGestion.php");
                          }else{
                            require_once("./vues/v_recettes.php");
                          }
                        }else{
                            require_once("./vues/v_recettes.php");
                        }
                        break;

    case 'consultationDetailsRecettes':
      require_once("./vues/v_recettesDetail.php");
      break;

    case 'addRecette':
      // Vérification des droits
      if(!isset($_SESSION['utilisateurConnecte']) || 
         unserialize($_SESSION['utilisateurConnecte'])->getRole() != "admin") {
          require_once("./vues/formulaires/v_formulaireAjoutRecette.php"); 
          break;
      }
      
      // Traitement de l'ajout de recette
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Debug
          error_log("POST reçu : " . print_r($_POST, true));
          error_log("FILES reçu : " . print_r($_FILES, true));
          
          // Récupération et nettoyage des données
          $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
          $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
          $idType = filter_input(INPUT_POST, 'idType', FILTER_VALIDATE_INT);

          // Validation des données
          $erreurs = [];
          
          if (empty($libelle)) {
              $erreurs[] = "Le nom de la recette est requis";
          }
          
          if (empty($description)) {
              $erreurs[] = "La description est requise";
          }
          
          if (!$idType) {
              $erreurs[] = "Le type de recette est requis";
          }

          // Gestion de l'image
          $image = null;
          if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
              $image = file_get_contents($_FILES['image']['tmp_name']);
          }

          // Si pas d'erreurs, on procède à l'ajout
          if (empty($erreurs)) {
              try {
                  $resultat = $recetteDAO->ajoutRecettes($libelle, $description, $image, $idType);
                  
                  if ($resultat) {
                      echo '<div class="alert alert-success">La recette a été ajoutée avec succès</div>';
                  } else {
                      echo '<div class="alert alert-danger">Erreur lors de l\'ajout de la recette</div>';
                  }
              } catch (Exception $e) {
                  echo '<div class="alert alert-danger">Une erreur est survenue : ' . $e->getMessage() . '</div>';
              }
          } else {
              echo '<div class="alert alert-danger">';
              echo 'Veuillez corriger les erreurs suivantes :';
              echo '<ul>';
              foreach ($erreurs as $erreur) {
                  echo '<li>' . $erreur . '</li>';
              }
              echo '</ul>';
              echo '</div>';
          }
          
          // Redirection vers la page de consultation
          header('Location: index.php?action=consultationRecettes');
          exit();
      } else {
          // Affichage du formulaire d'ajout
          require_once(__DIR__ . "/../vues/formulaires/v_formulaireAjoutRecette.php");
      }
      break;

    case 'updateRecette'    :
      require_once("./vues/formulaires/v_formulaireModifRecette.php");
      break;

    case 'recetteAdded'    :
      // Vérification des droits
      if(!isset($_SESSION['utilisateurConnecte']) || 
         unserialize($_SESSION['utilisateurConnecte'])->getRole() != "admin") {
          header('Location: index.php?action=consultationRecettes');
          exit();
      }
      
      // Traitement de l'ajout de recette
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Debug
          error_log("POST reçu : " . print_r($_POST, true));
          error_log("FILES reçu : " . print_r($_FILES, true));
          
          // Récupération et nettoyage des données
          $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
          $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
          $idType = filter_input(INPUT_POST, 'idType', FILTER_VALIDATE_INT);

          // Validation des données
          $erreurs = [];
          
          if (empty($libelle)) {
              $erreurs[] = "Le nom de la recette est requis";
          }
          
          if (empty($description)) {
              $erreurs[] = "La description est requise";
          }
          
          if (!$idType) {
              $erreurs[] = "Le type de recette est requis";
          }

          // Gestion de l'image
          $image = null;
          if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
              $image = file_get_contents($_FILES['image']['tmp_name']);
          } else {
              $erreurs[] = "L'image est requise";
          }

          // Si pas d'erreurs, on procède à l'ajout
          if (empty($erreurs)) {
              try {
                  $resultat = $recetteDAO->ajoutRecettes($libelle, $description, $image, $idType);
                  
                  if ($resultat) {
                      $_SESSION['message'] = 'La recette a été ajoutée avec succès';
                      $_SESSION['messageType'] = 'success';
                  } else {
                      $_SESSION['message'] = 'Erreur lors de l\'ajout de la recette';
                      $_SESSION['messageType'] = 'error';
                  }
              } catch (Exception $e) {
                  $_SESSION['message'] = 'Une erreur est survenue : ' . $e->getMessage();
                  $_SESSION['messageType'] = 'error';
              }
          } else {
              $_SESSION['message'] = 'Veuillez corriger les erreurs suivantes :';
              $_SESSION['erreurs'] = $erreurs;
              $_SESSION['messageType'] = 'error';
          }
          
          // Redirection vers la page de consultation
          header('Location: index.php?action=consultationRecettes');
          exit();
      } else {
          // Si ce n'est pas une requête POST, rediriger vers la page de consultation
          header('Location: index.php?action=consultationRecettes');
          exit();
      }
      break;
}
?>