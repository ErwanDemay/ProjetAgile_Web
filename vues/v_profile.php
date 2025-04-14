<br><br><br><br><br>

<?php
$utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);

echo "adresse mail : ".$utilisateurConnecte->getMail();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <div class="logbut">
<a href="index.php?controleur=utilisateurs&action=changerMotDePasse"><button>Changer votre mot de passe</button></a>
<a href="index.php?controleur=utilisateurs&action=connexion"><button>Déconnexion</button></a>
    </div>
</body>