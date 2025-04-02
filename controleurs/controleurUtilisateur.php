<?php
require_once("./modeles/Utilisateur.php");
require_once("./modeles/DAO/UtilisateurDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
$action= "consultation";}

switch ($action){
    case 'consultation'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                          $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                          require_once("./vues/v_profile.php");
                        }else{
                            require_once("./vues/formulaires/v_formulaireConnexion.php");
                        }
                        break;
}
?>