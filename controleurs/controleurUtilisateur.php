<?php
require_once("./modeles/Utilisateur.php");
require_once("./modeles/DAO/UtilisateurDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
$action= "consultationUtilisateurs";}

switch ($action){
    case 'consultationUtilisateurs'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                          $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                          if($utilisateurConnecte->getRole() == "admin"){
                            require_once("./vues/v_utilisateursGestion.php");
                          }else{
                            require_once("./vues/v_utilisateurs.php");
                          }
                        }else{
                            require_once("./vues/v_utilisateurs.php");
                        }
                        break;
}
?>