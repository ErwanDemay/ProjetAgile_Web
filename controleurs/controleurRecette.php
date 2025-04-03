<?php
require_once("./modeles/Recette.php");
require_once("./modeles/DAO/RecetteDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
$action= "consultationRecettes";}

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

    case 'consultationDetailsRecettes'    :
      echo "consult detail OK";
      break;
}
?>