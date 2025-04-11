<?php
require_once("./modeles/Utilisateur.php");
require_once("./modeles/DAO/UtilisateurDAO.php");

if (isset($_GET['action'])){
    $action=filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else {
$action= "consultation";}

// Initialiser le DAO
$UtilisateurDAO = new UtilisateurDAO();

switch ($action){
    case 'consultation'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                          $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                          require_once("./vues/v_profile.php");
                        }else{
                            require_once("./vues/formulaires/v_formulaireConnexion.php");
                        }
                        break;
                        case 'login'                :
                            include("./vues/formulaires/v_login.php");
                            break;
                            break;

    case 'connexion':
                        require_once("./vues/formulaires/v_formulaireConnexion.php");
                        break;

    case "creationCompte" :
                        require_once("./vues/formulaires/v_formulaireCreationCompte.php");
                        break;

    case 'signupEncours'        :
                        $email = $_POST['email'];
                        $motDePasse = $_POST['password'];
                        $role = $_POST['role'];

                        $existeDeja = $UtilisateurDAO->existeDeja($email);

                        if(($existeDeja) == 0){
                            $unUtilisateur = new Utilisateur(null, $email, $motDePasse, $role);

                            $resultat = $UtilisateurDAO->addUtilisateur($unUtilisateur);
                            
                            $_SESSION['message'] = '<div class="message">Le compte a été créé avec succès !</div>';
                            header("Location: ./index.php?controleur=utilisateurs&action=creationCompte");
                            exit();

                        }else{
                            $_SESSION['message'] = '<div class="message error">Un compte existe déjà avec cette adresse email.</div>';
                            header("Location: ./index.php?controleur=utilisateurs&action=creationCompte");
                            exit();
                        }
                        break;

    case 'loginEnCours'        :
                            $email = $_POST['email'];
                            $motDePasse = $_POST['password'];
    
                            $connectionUtilisateur = $UtilisateurDAO->verifConnection($email, $motDePasse);
                            if($connectionUtilisateur == false){
                                echo "<br><br><br><h1 style='color:black;'>Il y a une erreur dans l'adrese email ou le mot de passe</h1>";
                            }else{
                                $_SESSION['utilisateurConnecte'] = serialize($connectionUtilisateur);
                                header("Location: ./index.php?controleur=utilisateurs&action=profil");
                            }
                            break;
    case 'profil'               :
                            require_once("./vues/v_profile.php");
                            break;
}
?>