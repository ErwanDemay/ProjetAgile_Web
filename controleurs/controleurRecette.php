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
    case 'consultationRecettes':
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
                            // Rediriger l'utilisateur non-admin
                      require_once('./vues/formulaires/v_formulaireAjoutRecette.php');
                      exit();
                      }
                      
                      // Traitement de l'ajout de recette
                      if ($_SERVER["REQUEST_METHOD"] == "POST") {
                          // Debug
                          error_log("POST reçu : " . print_r($_POST, true));
                          error_log("FILES reçu : " . print_r($_FILES, true));
                          
                          // Récupération et nettoyage des données
                          $libelle = filter_var($_POST['libelle'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                          $description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                          $idType = filter_var($_POST['idType'] ?? 0, FILTER_VALIDATE_INT);

                          // Gestion de l'image
                          // Cette partie du code gère le téléchargement d'une image pour la recette
                          $image = null;  // On initialise la variable $image à null (pas d'image par défaut)
                          
                          // On vérifie si une image a été téléchargée et s'il n'y a pas d'erreur
                          if (isset($_FILES['image'])){
                              // Si une image a été correctement téléchargée, on lit son contenu
                              // $_FILES['image']['tmp_name'] est le chemin temporaire où l'image est stockée
                              // file_get_contents() transforme le fichier en données binaires
                              // Ces données pourront être stockées dans la base de données
                              $image = file_get_contents($_FILES['image']['tmp_name']);
                          }
                          // À la fin, $image contient soit les données de l'image, soit null si aucune image n'a été téléchargée

                          // Si pas d'erreurs, on procède à l'ajout
                          
                              try {
                                  $resultat = $recetteDAO->ajoutRecettes($libelle, $description, $image, $idType);
                                  
                                  if ($resultat) {
                                      // Redirection vers la page de consultation après l'ajout
                                      header('Location: index.php?controleur=recettes&action=consultationRecettes');
                                      exit();
                                  } else {
                                      echo('Erreur lors de l\'ajout de la recette');
                                  }
                              } catch (Exception $e) {
                                  echo($e->getMessage());
                              }
                  }
                
                }
?>
