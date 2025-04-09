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

    case 'sessionAdded':
      $sessionDAO = new SessionDAO();
    
      // Récupération des données du formulaire
      $nomSession = filter_var($_POST['nomSession'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $dateSession = filter_var($_POST['dateSession'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);  // Format: YYYY-MM-DD
      $heureDebut = filter_var($_POST['heureDebut'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);   // Format: HH:MM:SS
      $heureFin = filter_var($_POST['heureFin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);       // Format: HH:MM:SS
      $prix = filter_var($_POST['prix'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $nbPlaces = filter_var($_POST['nbPlacesSession'], FILTER_SANITIZE_NUMBER_INT);
    
      // Créer l'objet Session
      $laSession = new Session(
          null,          // ID sera auto-incrémenté
          $nomSession,   // Nom de la session
          $dateSession,  // Date de la session
          $heureDebut,   // Heure de début
          $heureFin,     // Heure de fin
          $prix,         // Prix de la session
          $nbPlaces      // Nombre de places disponibles
      );
    
      // Appeler la méthode ajoutSession avec les bons paramètres
      $resultat = $sessionDAO->ajoutSession($nomSession, $dateSession, $heureDebut, $heureFin, $prix, $nbPlaces);
    
      // Gérer le résultat
      if ($resultat) {
          // Succès
          $_SESSION['message'] = "La session a été ajoutée avec succès.";
      } else {
          // Échec
          $_SESSION['erreur'] = "Erreur lors de l'ajout de la session.";
      }
    
      // Rediriger vers la page des sessions
      header('Location: index.php?controleur=sessions&action=consultationSessions');
      exit();
      break;

    case 'updateSession':
  
      // Récupérer l'ID de la session à modifier
      $id = $_GET['id'];
  
      // Créer une instance de SessionDAO pour récupérer la session
      $connexionBD = new SessionDAO();
      $laSession = $connexionBD->getUneSession($id);  // Il faut créer cette méthode pour récupérer une session par ID
      include("./vues/formulaires/v_formulaireModifSession.php");  // Formulaire pour modifier la session
      break;
    
    case 'sessionUpdated':
    
        // Créer une instance de SessionDAO pour modifier la session
        $connexionBD = new SessionDAO();
    
        // Récupérer les données envoyées par le formulaire
        $id = $_POST['id'];
        $nomSession = $_POST['nomSession'];
        $dateSession = $_POST['dateSession'];
        $heureDebut = $_POST['heureDebut'];
        $heureFin = $_POST['heureFin'];
        $prix = $_POST['prixSession'];
        $nbPlaces = $_POST['nbPlacesSession'];
    
        // Créer une nouvelle instance de la session avec les données modifiées
        $laSession = new Session($id, $nomSession, $dateSession, $heureDebut, $heureFin, $prix, $nbPlaces);
    
        // Appeler la méthode pour modifier la session dans la base de données
        $resultat = $connexionBD->updateSession($laSession);  // Il faut créer la méthode updateSession
    
        // Rediriger vers la page des sessions après modification
        header('Location: index.php?controleur=sessions');
        exit();
        break;    

    case 'deleteSession':
      // Vérifier si l'ID de la session est fourni
      if (!isset($_GET['id']) || empty($_GET['id'])) {
          $_SESSION['erreur'] = "ID de session non spécifié.";
          header('Location: index.php?controleur=sessions&action=consultationSessions');
          exit();
      }
  
      // Récupérer l'ID de la session
      $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  
      // Créer une instance de SessionDAO
      $sessionDAO = new SessionDAO();
  
      // Supprimer la session
      $resultat = $sessionDAO->supprimerSession($id);
  
      // Gérer le résultat
      if ($resultat) {
          // Succès
          $_SESSION['message'] = "La session a été supprimée avec succès.";
      } else {
          // Échec
          $_SESSION['erreur'] = "Erreur lors de la suppression de la session.";
      }
  
      // Rediriger vers la page des sessions
      header('Location: index.php?controleur=sessions&action=consultationSessions');
      exit();
      break;
    
}
?>