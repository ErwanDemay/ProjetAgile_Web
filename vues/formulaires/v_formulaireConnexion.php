<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Préconnecter les domaines nécessaires -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Charger la police Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CookFusions Lab</title>
  <link rel="stylesheet" href="../../css/globals.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/formulaireConnexion.css">

</head>

<body>    
    <div class="container">
        <div class="form-container">
            <h2>Connexion</h2>
            <?php
            if(isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
            <form action ='index.php?controleur=utilisateurs&action=loginEnCours' method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre mail">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe">
                <button type="submit">Se connecter</button>
            </form>
        </div>
        <div class="image-container">
            <img src="../images/logoCookFusionLab.png" alt="Image illustrative">
        </div>
    </div>

</body>
</html>