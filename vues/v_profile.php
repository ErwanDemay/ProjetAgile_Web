<br><br><br><br><br>
<p>v_profile</p>
<?php
$utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);

echo "adresse mail : ".$utilisateurConnecte->getMail();
?>
<a href="index.php?controleur=utilisateurs&action=changerMotDePasse"><button>Changer votre mot de passe</button></a>
<a href="index.php?controleur=utilisateurs&action=connexion"><button>Déconnexion</button></a>