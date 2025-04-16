<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la recette</title>
    <link rel="stylesheet" href="../css/detailrecette.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <div class="header-btn-container">
        <a href="index.php?controleur=recettes&action=consultationRecettes" class="add-recipe-btn">Retour aux recettes</a>
    </div>
    
    <section class="card-container">
        <div class="card">
            <div class="card-header"><?php echo $laRecette->getLibelle(); ?></div>
            <div class="card-image">
                <img src="<?php echo $laRecette->getUneImage(); ?>" alt="<?php echo $laRecette->getLibelle(); ?>" class="card-image">
            </div>
            <div class="card-type">
                <?php 
                $type = "";
                switch($laRecette->getId_Type()) {
                    case 1:
                        $type = "Entrée";
                        break;
                    case 2:
                        $type = "Plat";
                        break;
                    case 3:
                        $type = "Dessert";
                        break;
                    default:
                        $type = "Type inconnu";
                }
                echo "Type : " . $type;
                ?>
            </div>
            <button class="card-button" onclick="window.location.href='./index.php?controleur=sessions&action=consultationSessions&filtre=<?= $laRecette->getId() ?>'">Voir les sessions associées</button>
        </div>
        <div class="card-texte">
            <div class="card-texte-header">
                <h2>Description</h2>
            </div>
            <div class="card-texte-body">
                <p><?php echo nl2br($laRecette->getDescription()); ?></p>
            </div>
        </div>
    </section>
</body>
</html>
