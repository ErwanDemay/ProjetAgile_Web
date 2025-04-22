<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sessions.css">
</head>
<body>
<h1>Les utilisateurs</h1>
<div class="button-container">
    <a href="../index.php?controleur=utilisateurs&action=creationCompte" class="button-add">Créer un compte</a>
</div>
<div class="table-container">
<table>
    <thead>
        <tr>
            <th>Adresse mail</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $utilisateurDAO = new UtilisateurDAO();

        $lesUtilisateurs = $utilisateurDAO->getLesUtilisateurs();
        
        if ($lesUtilisateurs) {
            foreach ($lesUtilisateurs as $utilisateur) {
                echo "<tr>" .
                    "<td><p>" . htmlspecialchars($utilisateur->getMail()) . "</p></td>" .
                    "<td><p>" . htmlspecialchars($utilisateur->getRole()) . "</p></td>" .
                    "<td>" .
                    "<a href='index.php?controleur=utilisateurs&action=updateUtilisateur&id=" . $utilisateur->getId() . "'>" .
                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='25' height='25'>" .
                            "<path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/>" .
                        "</svg>" .
                    "</a>" .
                    "<a href='index.php?controleur=utilisateurs&action=deleteUtilisateur&id=" . $utilisateur->getId() . "'>" .
                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' width='25' height='25'>" .
                            "<path d='M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z'/>" .
                        "</svg>" .
                    "</a>" .
                    "<a href='./index.php?controleur=utilisateurs&action=voirSessionsUtilisateur&id=" . $utilisateur->getId() . "' class='card-button'>Voir réservations</a>".
                    "</td>" .
                    "</tr>";
            }
        } else {
            echo "Il n'existe aucun utilisateur.";
        }
    ?>
    </tbody>
</table>
</div>

<style>
.recette-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3px 0;
}

.delete-recette {
    opacity: 0.7;
    transition: opacity 0.2s;
    margin-left: 8px;
    display: inline-flex;
    align-items: center;
}

.delete-recette:hover {
    opacity: 1;
}
</style>
</body>
</html>
