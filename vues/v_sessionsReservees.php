<?php
$utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les sessions réservées</title>
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/sessions.css">
</head>
<body>

<?php
if ($utilisateurConnecte->getRole() === "admin") {
    if ($lesSessions && count($lesSessions) > 0) {
?>
    <h2>Les sessions réservées par l'utilisateur</h2>
    <div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Heure début</th>
                <th>Heure fin</th>
                <th>Prix</th>
                <th>Places restantes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
<?php
        foreach ($lesSessions as $session) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($session->getNomSession()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getDateSession()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getHeureDebut()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getHeureFin()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getPrix()) . " €</td>";
            echo "<td>" . htmlspecialchars($connexionBD->getNbPlacesRestantes($session)) . "</td>";
            echo "<td><a href='index.php?controleur=utilisateurs&action=voirSessionsUtilisateur&id=" . $idUtilisateur . "&idSession=".$session->getId()."' class='card-button red-button'>Désinscrire l'utilisateur</a></td>";
            echo "</tr>";
        }
?>
        </tbody>
    </table>
    </div>
<?php
    } else {
        echo "<p>L'utilisateur n'a réservé aucune session.</p>";
    }
}
?>
</body>
</html>