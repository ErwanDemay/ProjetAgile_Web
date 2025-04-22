<?php
$utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/sessions.css">
</head>
<body>
    <h1>Votre profil</h1>
    <p>Adresse mail : <?= htmlspecialchars($utilisateurConnecte->getMail()) ?></p><br>

    <div class="logbut">
        <a href="index.php?controleur=utilisateurs&action=changerMotDePasse" class='card-button'>Changer votre mot de passe</a>
        <a href="index.php?controleur=utilisateurs&action=connexion" class='card-button'>Déconnexion</a><br>
    </div>

<?php
if ($utilisateurConnecte->getRole() === "user") {

    $SessionDAO = new SessionDAO();
    $mesSessions = $SessionDAO->getSessionsReserveesParUtilisateur($utilisateurConnecte->getId()); // À créer si pas encore fait

    if ($mesSessions && count($mesSessions) > 0) {
?>
    <h2>Vos sessions réservées</h2>
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
        foreach ($mesSessions as $session) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($session->getNomSession()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getDateSession()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getHeureDebut()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getHeureFin()) . "</td>";
            echo "<td>" . htmlspecialchars($session->getPrix()) . " €</td>";
            echo "<td>" . htmlspecialchars($connexionBD->getNbPlacesRestantes($session)) . "</td>";
            echo "<td><a href='index.php?controleur=sessions&action=desinscrireUneSessionProfil&id=" . $session->getId() . "' class='card-button red-button'>Se désinscrire</a></td>";
            echo "</tr>";
        }
?>
        </tbody>
    </table>
    </div>
<?php
    } else {
        echo "<p>Vous n'avez réservé aucune session.</p>";
    }
}
?>
</body>
</html>
