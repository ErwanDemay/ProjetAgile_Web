<?php
session_start();
?>

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
  <link rel="stylesheet" href="css/index.css">

</head>
<body>
<nav class="navbar">
            <a href="./index.php" class="nav-title">CookFusions Lab</a>
        <div class="nav-links">
            <a href="./index.php?controleur=recettes" data-index="0">Nos recettes</a>
            <a href="./index.php?controleur=sessions" data-index="1">Prochaines sessions</a>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M406.5 399.6C387.4 352.9 341.5 320 288 320l-64 0c-53.5 0-99.4 32.9-118.5 79.6C69.9 362.2 48 311.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208c0 55.7-21.9 106.2-57.5 143.6zm-40.1 32.7C334.4 452.4 296.6 464 256 464s-78.4-11.6-110.5-31.7c7.3-36.7 39.7-64.3 78.5-64.3l64 0c38.8 0 71.2 27.6 78.5 64.3zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-272a40 40 0 1 1 0-80 40 40 0 1 1 0 80zm-88-40a88 88 0 1 0 176 0 88 88 0 1 0 -176 0z"/></svg>
        </div>
        

      <?php
      //if(isset($_SESSION['utilisateurConnecte'])){ 
      //  $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
      //  if($utilisateurConnecte->getRole() == "admin"){
      //  }
      //}?>

    </ul>
  </nav>

<?php
            if (isset($_GET['controleur']))
				$controleur=filter_var($_GET['controleur'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			else
				$controleur="default";
                    
            switch ($controleur){
                    case 'default':
                        require_once("./vues/v_index.php"); 
                        break;
                    case 'sessions' : 
                        require_once("./controleurs/controleurSession.php"); 
                        break;
                    case 'utilisateurs' : 
                        require_once("./controleurs/controleurUtilisateur.php"); 
                        break;
                    case 'recettes' : 
                        require_once("./controleurs/controleurRecette.php"); 
                        break;
            }
?>

<a href='./index.php'>Cliquez ici pour voir nos mentions légales</a>
</body>
</html>