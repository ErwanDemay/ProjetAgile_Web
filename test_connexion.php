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

// Affichage du résultat
header('Content-Type: application/json');
echo json_encode($resultat, JSON_PRETTY_PRINT); 