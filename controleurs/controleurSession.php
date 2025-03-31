<?php
require_once("./modeles/Session.php");
require_once("./modeles/DAO/SessionDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
$action= "consultationSessions";}

switch ($action){
    case 'consultationSessions'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                          $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                          if($utilisateurConnecte->getRole() == "admin"){
                            require_once("./vues/v_sessionsGestion.php");
                          }else{
                            require_once("./vues/v_sessions.php");
                          }
                        }else{
                            require_once("./vues/v_sessions.php");
                        }
                        break;
}
?>