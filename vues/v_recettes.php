<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<?php
// Affichage des messages
if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['messageType'] == 'success' ? 'success' : 'danger'; ?>">
        <?php 
        echo $_SESSION['message'];
        if (isset($_SESSION['erreurs'])) {
            echo '<ul>';
            foreach ($_SESSION['erreurs'] as $erreur) {
                echo "<li>$erreur</li>";
            }
            echo '</ul>';
        }
        ?>
    </div>
    <?php 
    // Nettoyage des messages après affichage
    unset($_SESSION['message']);
    unset($_SESSION['messageType']);
    unset($_SESSION['erreurs']);
    ?>
<?php endif; ?>

    <section class="search-container">
        
        <div class="menu">
            <div class="dropdown">
                <?php
                // Définir le texte du bouton en fonction du type sélectionné
                $buttonText = "Toutes les recettes";
                if (isset($_GET['type'])) {
                    switch ($_GET['type']) {
                        case '1':
                            $buttonText = "Entrées";
                            break;
                        case '2':
                            $buttonText = "Plats";
                            break;
                        case '3':
                            $buttonText = "Desserts";
                            break;
                    }
                }
                ?>
                <button class="menu-button"><?php echo $buttonText; ?></button>
                <div class="dropdown-content">
                    <a href="index.php?controleur=recettes&action=consultationRecettes">Toutes les recettes</a>
                    <a href="index.php?controleur=recettes&action=consultationRecettes&type=1">Entrées</a>
                    <a href="index.php?controleur=recettes&action=consultationRecettes&type=2">Plats</a>
                    <a href="index.php?controleur=recettes&action=consultationRecettes&type=3">Desserts</a>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (isset($_SESSION['utilisateurConnecte'])) {
        $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
        if ($utilisateurConnecte->getRole() === "admin") {
            echo '<div class="header-btn-container">
                    <a href="index.php?controleur=recettes&action=addRecette" class="add-recipe-btn">Ajouter une recette</a>
                </div>';
        }
    }
    ?>
    <main>
        <section class="card-container">
        <?php foreach ($lesRecettes as $recette): ?>
            <div class="card">
                <div class="card-header"><?php echo $recette->getLibelle(); ?></div>
                <div class="card-body">
                    <img src="<?php echo $recette->getUneImage(); ?>" alt="<?php echo $recette->getLibelle(); ?>" class="card-image">
                </div>
                <div class="button-container">
                    <a href="./index.php?controleur=recettes&action=consultationDetailsRecettes&id=<?php echo $recette->getId(); ?>" class="card-button">Voir plus</a>

                    <?php
                    if (isset($_SESSION['utilisateurConnecte'])) {
                        if ($utilisateurConnecte->getRole() === "admin") {
                            echo '<a href="./index.php?controleur=recettes&action=editRecette&id=' . $recette->getId() . '" class="card-button">Modifier</a>';
                            echo '<a href="./index.php?controleur=recettes&action=deleteRecette&id=' . $recette->getId() . '" class="card-button" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette recette ?\')">Supprimer</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
