<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Préconnecter les domaines nécessaires -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
  <!-- Charger la police Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CookFusions Lab</title>
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  
<main>
  <div class="page_title">
    <h2>Nos 3 dernières recettes</h2>
  </div> 
  <section class="card-container">
    <?php if (isset($lesRecettes) && !empty($lesRecettes)): ?>
      <?php foreach ($lesRecettes as $recette): ?>
      <div class="card">
        <div class="card-header"><?php echo $recette->getLibelle(); ?></div>
        <div class="card-body">
          <img src="<?php echo $recette->getUneImage(); ?>" alt="<?php echo $recette->getLibelle(); ?>" class="card-image">
        </div>
        <div class="button-container">
          <a href="./index.php?controleur=recettes&action=consultationDetailsRecettes&id=<?php echo $recette->getId(); ?>" class="card-button">Voir plus</a>
        </div>
      </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune recette disponible pour le moment.</p>
    <?php endif; ?>
  </section>
</main>
</body>
</html> 