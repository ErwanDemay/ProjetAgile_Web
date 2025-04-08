<?php
// Inclure les fichiers nécessaires
require_once(__DIR__ . "/modeles/Recette.php");
require_once(__DIR__ . "/modeles/DAO/RecetteDAO.php");

// Vérifier si l'ID de la recette est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Afficher une image par défaut si aucun ID n'est fourni
    header('Content-Type: image/jpeg');
    readfile(__DIR__ . '/images/logoCookFusionLab.png');
    exit;
}

// Récupérer l'ID de la recette
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

// Créer une instance de RecetteDAO
$recetteDAO = new RecetteDAO();

// Récupérer l'image de la recette
$image = $recetteDAO->getImageRecette($id);

// Vérifier si l'image existe
if ($image) {
    // Définir le type de contenu
    header('Content-Type: image/jpeg');
    
    // Afficher l'image
    echo $image;
} else {
    // Afficher une image par défaut si aucune image n'est trouvée
    header('Content-Type: image/jpeg');
    readfile(__DIR__ . '/images/logoCookFusionLab.png');
}
?> 