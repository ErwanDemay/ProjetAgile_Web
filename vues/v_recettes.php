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
        <div class="search">
            <input type="text" placeholder="Recherchez une recette" class="search-bar">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
        </div>
        <div class="menu">
            <div class="dropdown">
                <button class="menu-button">Filtres</button>
                <div class="dropdown-content">
                    <button>Entrée</button>
                    <button>Plat</button>
                    <button>Dessert</button>
                </div>
            </div>
        </div>
    </section>
    <div class="header-btn-container">
        <a href="index.php?controleur=recettes&action=addRecette" class="add-recipe-btn">Ajouter une recette</a>
    </div>
    <main>
        <section class="card-container">
            <?php foreach ($lesRecettes as $recette): ?>
            <div class="card">
                <div class="card-header"><?php echo $recette->getLibelle(); ?></div>
                <div class="card-body">
                <img src="../afficherImage.php?id=<?php echo $recette->getId(); ?>" alt="<?php echo $recette->getLibelle(); ?>" class="card-image">
                </div>
                <div class="button-container">
                <a href="./index.php?controleur=recettes&action=consultationDetailsRecettes&id=<?php echo $recette->getId(); ?>" class="card-button">Voir plus</a>
                <a href="./index.php?controleur=recettes&action=updateRecette&id=<?php echo $recette->getId(); ?>" class="card-button">Modifier</a>
                <a href="./index.php?controleur=recettes&action=deleteRecette&id=<?php echo $recette->getId(); ?>" class="card-button">Supprimer</a>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>
