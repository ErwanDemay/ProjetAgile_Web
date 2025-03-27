<?php
session_start();
include('./modeles/dao/dao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pic du Midi</title>
  <link rel="stylesheet" href="css/index.css">

</head>
<body>
  <nav>
    <ul>
      <li><a class="navBoutton" href="./index.php">Accueil</a></li>
      <li><a class="navBoutton" href="./index.php?controleur=session">Prochaines sessions</a></li>

      <?php
      if(isset($_SESSION['utilisateurConnecte'])){ 
        $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
        if($utilisateurConnecte->getRole() == "admin"){
          echo "".
              "<li class='sousMenu'>".
                "<a class='navBoutton'>Gestion</a>".
                "<ul class='sousMenuUl'>".
                  "<li><a href='./index.php?controleur=session'>Sessions</a></li>".
                  "<li><a href='./index.php?controleur=utilisateur'>Utilisateurs</a></li>".
                  "<li><a href='./index.php?controleur=recette'>Recettes</a></li>".
                "</ul>".
              "</li>";
        }
      }?>

    </ul>
  </nav>

<?php
            if (isset($_GET['controleur']))
				$controleur=filter_var($_GET['controleur'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			else
				$controleur="default";
                    
            switch ($controleur){
                    case 'default':
                        include("./vues/v_index.php"); 
                        break;
                    case 'sessions' : 
                        include("./controleurs/controleurSession.php"); 
                        break;
                    case 'utilisateur' : 
                        include("./controleurs/controleurUtilisateur.php"); 
                        break;
                    case 'utilisateur' : 
                        include("./controleurs/controleurUtilisateur.php"); 
                        break;
            }
?>

<a href='./index.php'>Cliquez ici pour voir nos mentions légales</a>
</body>
</html>