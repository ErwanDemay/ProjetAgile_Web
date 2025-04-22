<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sessions.css">
</head>
<body>
<h1>Prochaines sessions</h1>
<?php if (isset($laRecette)) { ?>
    <h2>Sessions associées à la recette : <?= $laRecette->getLibelle() ?></h2>
<?php }
if (isset($_SESSION['utilisateurConnecte'])) {
    $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
    if ($utilisateurConnecte->getRole() === "admin") {
?>
    <div class="button-container">
        <a href="../index.php?controleur=sessions&action=addSession" class="button-add">Ajouter une session</a>
    </div>
<?php
    }
}
?>
<div class="table-container">
<table>
    <thead>
        <tr>
            <th>Nom de la session</th>
            <th>Date de la session</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th>Recettes Associées</th>
            <th>Prix</th>
            <th>Nb de places</th>
            <th>Nb de places restantes</th>
            <?php
            if (isset($_SESSION['utilisateurConnecte'])) {
                $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                if ($utilisateurConnecte->getRole() === "admin" || $utilisateurConnecte->getRole() === "user") {
            ?>
            <th>Actions</th>
            <?php
                }
            }
            ?>
        </tr>
    </thead>
    <tbody>
    <?php
        if ($lesSessions) {
            // Créer une instance de SessionDAO
            $SessionDAO = new SessionDAO();

            foreach ($lesSessions as $Session) {
                // Récupérer les recettes associées à la session
                $recettes = $SessionDAO->getLesRecettesDeLaSession($Session->getId());
                echo "<tr>";
                echo "<td><p>" . htmlspecialchars($Session->getNomSession()) . "</p></td>";
                echo "<td><p>" . htmlspecialchars($Session->getDateSession()) . "</p></td>";
                echo "<td><p>" . htmlspecialchars($Session->getHeureDebut()) . "</p></td>";
                echo "<td><p>" . htmlspecialchars($Session->getHeureFin()) . "</p></td>";
                
                echo "<td><p>";
                if ($recettes) {
                    foreach ($recettes as $recette) {
                        echo "<div class='recette-item'>
                                <span>" . $recette['libelle'] . "</span>";
                        
                        if (isset($_SESSION['utilisateurConnecte'])) {
                            if ($utilisateurConnecte->getRole() === "admin") {
                                echo "<a href='index.php?controleur=sessions&action=supprimerRecetteSession&idRecette=" . $recette['id'] . "&idSession=" . $Session->getId() . "'
                                           class='delete-recette'
                                           onclick='return confirm(\"Êtes-vous sûr de vouloir retirer cette recette de la session ?\");'>
                                           <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' width='14' height='14' fill='#ff4444'>
                                               <path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/>
                                           </svg>
                                      </a>";
                            }
                        }
                
                        echo "</div>";
                    }
                } else {
                    echo "Aucune recette associée.";
                }                
                echo "</p></td>";
                echo "<td><p>" . htmlspecialchars($Session->getPrix()) . " €</p></td>";
                echo "<td><p>" . htmlspecialchars($Session->getNbPlaces()) . "</p></td>";
                echo "<td><p>" . htmlspecialchars($connexionBD->getNbPlacesRestantes($Session)) . "</p></td>";
                
                // Boutons d'action (admin uniquement)                
                if (isset($_SESSION['utilisateurConnecte'])) {
                    if ($utilisateurConnecte->getRole() === "admin") {
                        echo "<td>";
                        echo "<a href='index.php?controleur=sessions&action=updateSession&id=" . $Session->getId() . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='25' height='25'>
                                    <path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/>
                                </svg>
                              </a>";
                        echo "<a href='index.php?controleur=sessions&action=deleteSession&id=" . $Session->getId() . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' width='25' height='25'>
                                    <path d='M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z'/>
                                </svg>
                              </a>";
                        echo "<a href='index.php?controleur=sessions&action=addRecetteASession&id=" . $Session->getId() . "'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' width='25' height='25'>
                                    <path d='M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32v144H48c-17.7 0-32 14.3-32 32s14.3 32 32 32h144v144c0 17.7 14.3 32 32 32s32-14.3 32-32V288h144c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z'/>
                                </svg>
                              </a>";
                        echo "</td>";
                        echo "</tr>";  
                    } elseif ($utilisateurConnecte->getRole() === "user") {
                        echo "<td>";
                        if ($connexionBD->aReserveSession($utilisateurConnecte->getId(), $Session->getId())) {
                            echo "<a href='./index.php?controleur=sessions&action=desinscrireUneSession&id=" . $Session->getId() . "' class='card-button red-button'>Se désinscrire</a>";
                        } else {
                            echo "<a href='./index.php?controleur=sessions&action=reserverUneSession&id=" . $Session->getId() . "' class='card-button'>Réserver</a>";
                        }                        echo "</td>";
                        echo "</tr>";  
                    }
                }                              
            }
        } else {
            echo "Aucune session disponible.";
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
<script>
    function refreshPage() {
        location.reload();  // Cette fonction recharge la page actuelle
    }
</script>
</body>
</html>
