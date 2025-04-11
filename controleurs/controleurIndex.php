<?php

require_once(__DIR__ . "/../modeles/Recette.php");
require_once(__DIR__ . "/../modeles/DAO/RecetteDAO.php");

if (isset($_GET['action'])){
  $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
  $action= "consultationDernieresRecettes";
}

switch ($action){
  case "consultationDernieresRecettes":
    $recetteDAO = new RecetteDAO();
    $lesRecettes = $recetteDAO->getLastRecettes();

    require_once(__DIR__ . "/../vues/v_index.php");
    break;
// Un contrôleur entier pour 3 lignes ? On peut faire d'autres cases pour l'index ?
  }


?>