<?php
session_start();
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
      <li><a class="navBoutton" href="./index.php?controleur=sessions">Prochaines sessions</a></li>

      <?php
      //if(isset($_SESSION['utilisateurConnecte'])){ 
      //  $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
      //  if($utilisateurConnecte->getRole() == "admin"){
          echo "".
              "<li class='sousMenu'>".
                "<a class='navBoutton'>Gestion</a>".
                "<ul class='sousMenuUl'>".
                  "<li><a href='./index.php?controleur=sessions'>Sessions</a></li>".
                  "<li><a href='./index.php?controleur=utilisateurs'>Utilisateurs</a></li>".
                  "<li><a href='./index.php?controleur=recettes'>Recettes</a></li>".
                "</ul>".
              "</li>";
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