
<?php
require_once 'connexionBase.php';

try {
    $conn = connexionPDO();
    
    $sql = "SELECT * FROM visiteur ";
    $requete = $conn->prepare($sql);
    $requete->execute();
    
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // Afficher le résultat en JSON
    echo json_encode($result);
    
} catch (PDOException $e) {
    print "Erreur dans la connexion à la base de données";
    print $e;
    die();
}
?>