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
    <div class="card">
      <div class="card-header">Image 1</div>
      <div class="card-body">
        <img src="../images/logoCookFusionLab.png" alt="Image 1" class="card-image">
      </div>
      <button class="card-button" onclick="window.location.href='./index.php?controleur=recettes&action=consultationDetailsRecettes'">Voir plus</button>
    </div>
    <div class="card">
      <div class="card-header">Image 2</div>
      <div class="card-body">
        <img src="../images/logoCookFusion.png" alt="Image 2" class="card-image">
      </div>
      <button class="card-button">Voir plus</button>
    </div>
    <div class="card">
      <div class="card-header">Image 3</div>
      <div class="card-body">
        <img src="../images/logoCookFusion.png" alt="Image 3" class="card-image">
      </div>
      <button class="card-button">Voir plus</button>
    </div>
  </section>
</main>
</body>
</html>