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
                        // Déconnecte l'utilisateur, c'est ici que redirige le bouton Déconnexion de la page profil
                        unset($_SESSION['utilisateurConnecte']);
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
                            echo "<h1 style='display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            font-size: 24px;
                            text-align: center;
                            color: red;
                            border: 1px solid #f5c6cb;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1)'>Il y a une erreur dans l'adrese email ou le mot de passe</h1>"; // Tout ces br c'est moche il faut du css ici aussi
                        }else{
                            $_SESSION['utilisateurConnecte'] = serialize($connectionUtilisateur);
                            header("Location: ./index.php?controleur=utilisateurs&action=profil");
                        }
                        break;
    case 'profil'               :
                        require_once("./vues/v_profile.php");
                        break;
    case 'changerMotDePasse'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                            $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);

                            require_once("./vues/formulaires/v_formulaireChangerMotDePasse.php");
                        
                            if(isset($_POST['ancienMotDePasse']) && isset($_POST['nouveauMotDePasse'])){
                                $ancienMotDePasse = $_POST['ancienMotDePasse'];
                                $nouveauMotDePasse = $_POST['nouveauMotDePasse'];

                                // Vérification de la complexité du nouveau mot de passe
                                $motDePasseValide = preg_match(
                                    '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
                                    $nouveauMotDePasse
                                );

                                if ($motDePasseValide) {
                                    $modification = $UtilisateurDAO->editMotDePasse($utilisateurConnecte, $ancienMotDePasse, $nouveauMotDePasse);
                                   
                                    if($modification){
                                        echo "Mot de passe mit à jour";
                                    }
                                }else{
                                    echo "Le nouveau mot de passe ne respecte pas les critères de complexité.";
                                }
                            }else{
                                echo "Veuillez remplir tous les champs.";
                            }
                        }
                        break;
    case 'gestion'              :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                            $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                            if($utilisateurConnecte->getRole() == "admin"){
                                require_once('./vues/v_utilisateurs.php');
                            }
                        }
                        break;
    case 'updateUtilisateur'    :
                        if (isset($_SESSION['utilisateurConnecte'])) {
                            $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                            if ($utilisateurConnecte->getRole() == "admin") {
                    
                                if (isset($_POST['id']) && isset($_POST['mail']) && isset($_POST['motDePasse']) && isset($_POST['role'])) {
                                    $id = $_POST['id'];
                                    $mail = $_POST['mail'];
                                    $motDePasse = $_POST['motDePasse'];
                                    $role = $_POST['role'];
                    
                                    if ($id != null && $mail != null && $motDePasse != null && $role != null) {
                                        $lUtilisateur = new Utilisateur($id, $mail, $motDePasse, $role);
                                        $resultat = $UtilisateurDAO->editUtilisateur($lUtilisateur);
                                    }
                                    header("Location: ./index.php?controleur=utilisateurs&action=gestion");
                                } else {
                                    $id = $_GET['id'];
                                    $unUtilisateur = $UtilisateurDAO->getUtilisateurById($id);
                                    require_once('./vues/formulaires/v_formulaireModifUtilisateur.php');
                                }
                            }
                        }
                        break;
    case 'deleteUtilisateur'    :
                        if(isset($_SESSION['utilisateurConnecte'])){ 
                            $utilisateurConnecte = unserialize($_SESSION['utilisateurConnecte']);
                            if($utilisateurConnecte->getRole() == "admin"){
                                $id = $_GET['id'];
                                $UtilisateurDAO->deleteUtilisateur($id);
                            }
                        }
                        header("Location: ./index.php?controleur=utilisateurs&action=gestion");
                        break;
}
?>