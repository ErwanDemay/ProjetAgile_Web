<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sessions.css">
    <title>Sessions associées</title>
</head>
<body>

<h1>Sessions associées à la recette : <?php echo htmlspecialchars($laRecette->getLibelle()); ?></h1>

<div class="button-container">
    <a href="index.php?controleur=recettes&action=consultationRecettes" class="button-add">Retour aux recettes</a>
</div>

<div class="table-container">
<table>
    <thead>
        <tr>
            <th>Nom de la session</th>
            <th>Date de la session</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th>Prix</th>
            <th>Nb de places</th>
            <th>Nb de places restantes</th>
            <?php if (isset($_SESSION['utilisateurConnecte'])) {
                $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                if ($utilisateurConnecte->getRole() === "admin") {
                    echo "<th>Actions</th>";
                }
            } ?>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($lesSessionsAssociees) {
        foreach ($lesSessionsAssociees as $session) {
            echo "<tr>";
            echo "<td><p>" . htmlspecialchars($session->getNomSession()) . "</p></td>";
            echo "<td><p>" . htmlspecialchars($session->getDateSession()) . "</p></td>";
            echo "<td><p>" . htmlspecialchars($session->getHeureDebut()) . "</p></td>";
            echo "<td><p>" . htmlspecialchars($session->getHeureFin()) . "</p></td>";
            echo "<td><p>" . htmlspecialchars($session->getPrix()) . " €</p></td>";
            echo "<td><p>" . htmlspecialchars($session->getNbPlaces()) . "</p></td>";
            echo "<td><p>" . htmlspecialchars($sessionDAO->getNbPlacesRestantes($session)) . "</p></td>";

            // Actions admin
            if (isset($utilisateurConnecte) && $utilisateurConnecte->getRole() === "admin") {
                echo "<td>";
                echo "<a href='index.php?controleur=sessions&action=updateSession&id=" . $session->getId() . "'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='20' height='20'>
                            <path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/>
                        </svg>
                      </a>";
                echo "<a href='index.php?controleur=sessions&action=deleteSession&id=" . $session->getId() . "' onclick='return confirm(\"Supprimer cette session ?\");'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' width='20' height='20'>
                            <path d='M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z'/>
                        </svg>
                      </a>";
                echo "</td>";
            }

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Aucune session associée à cette recette.</td></tr>";
    }
    ?>
    </tbody>
</table>
</div>

</body>
</html>
