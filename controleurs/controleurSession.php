<?php
require_once("./modeles/Session.php");
require_once("./modeles/DAO/SessionDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
$action= "consultationSessions";}
switch ($action){
    case 'consultationSessions'    :
      $connexionBD = new SessionDAO();
      $lesSessions = $connexionBD->getLesSessions();
      require_once("./vues/v_sessions.php");
      break;

    case 'addSession'    :
      require_once("./vues/formulaires/v_formulaireAjoutSession.php");
      break;

    case 'sessionAdded'    :
      require_once("./vues/formulaires/v_formulaireAjoutSession.php");
      break;

    case 'updateSession'    :
      require_once("./vues/formulaires/v_formulaireModifSession.php");
      break;

}
?>