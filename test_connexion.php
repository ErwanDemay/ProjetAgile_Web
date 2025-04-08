<?php
require_once 'modeles/base.php';

class TestConnexion extends Base {
    public function __construct() {
        parent::__construct();
    }
}

// Création d'une instance et test de la connexion
$test = new TestConnexion();
$resultat = $test->testerConnexion();

// Affichage du résultat de manière plus lisible
echo "<h2>Test de connexion à la base de données</h2>";
if ($resultat['success']) {
    echo "<p style='color: green;'>✅ " . $resultat['message'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ " . $resultat['message'] . "</p>";
}

// Affichage des informations de connexion (sans le mot de passe)
echo "<h3>Informations de connexion :</h3>";
echo "<ul>";
echo "<li>Host : " . getenv('DB_HOST') . "</li>";
echo "<li>Base de données : " . getenv('DB_NAME') . "</li>";
echo "<li>Utilisateur : " . getenv('DB_USER') . "</li>";
echo "</ul>"; 