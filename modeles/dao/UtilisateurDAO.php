<?php
// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");
include_once (__DIR__ . "/../Utilisateur.php");

class UtilisateurDAO extends Base {

  public function __construct(){
    parent::__construct();
    parent::setConnexionBase();
}

  /**
     * ajoute un utilisateur à partir des informations fournies par le formualire v_signup.php
     * @param Utilisateur $unUtilisateur    objet utilisateur contenant les informations nécessaire pour l'ajout du tuple
     * @return $resultatDeLaRequete    retourne une valeur numérique indiquant si l'utilisateur' a bien été ajouté
     */
    public function addUtilisateur($unUtilisateur){
      try {
          // Charger le poivre depuis le fichier .env
          $poivre = getenv('APP_POIVRE');
          if (!$poivre) {
              error_log("Erreur : Poivre non trouvé dans le fichier .env");
              return false;
          }

          // Récupérer les données de l'utilisateur
          $email = $unUtilisateur->getMail();
          $motDePasse = $unUtilisateur->getMotDePasse();
          $role = $unUtilisateur->getRole();

          // Concaténer le mot de passe avec le poivre
          $motDePasseAvecPoivre = $motDePasse . $poivre;

          // Hasher le mot de passe avec le poivre
          $motDePasseHashe = password_hash($motDePasseAvecPoivre, PASSWORD_DEFAULT);

          // Préparer la requête SQL
          $ordreSQL = "INSERT INTO Utilisateur (mail, motDePasse, role) 
                       VALUES (:mail, :motDePasse, :role)";
          
          $reqPrepa = $this->prepare($ordreSQL);

          // Lier les paramètres
          $reqPrepa->bindParam(':mail', $email);
          $reqPrepa->bindParam(':motDePasse', $motDePasseHashe);
          $reqPrepa->bindParam(':role', $role);

          // Exécuter la requête
          $resultatDeLaRequete = $reqPrepa->execute();

          return $resultatDeLaRequete;
      } catch (PDOException $e) {
          error_log("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
          return false;
      }
    }

    public function existeDeja($mail){
      $ordreSQL = "SELECT COUNT(mail) AS existeDeja FROM Utilisateur WHERE mail = :mail";

      $reqPrepa = $this->prepare($ordreSQL);
      $reqPrepa->bindParam(':mail', $mail);
      $reqPrepa->execute();
      $resultatDeLaRequete = $reqPrepa->fetch(PDO::FETCH_ASSOC);

      return (int)$resultatDeLaRequete['existeDeja'];
  }

  /**
   * Récupère un utilisateur à partir de son email
   * @param string $email L'email de l'utilisateur à récupérer
   * @return Utilisateur|null L'utilisateur trouvé ou null si aucun utilisateur n'a été trouvé
   */
  public function getUtilisateurByEmail($email) {
    try {
      $ordreSQL = "SELECT id, mail, motDePasse, role FROM Utilisateur WHERE mail = :email";
      
      $reqPrepa = $this->prepare($ordreSQL);
      $reqPrepa->bindParam(':email', $email);
      $reqPrepa->execute();
      
      $resultat = $reqPrepa->fetch(PDO::FETCH_ASSOC);
      
      if ($resultat) {
        return new Utilisateur(
          $resultat['id'],
          $resultat['mail'],
          $resultat['motDePasse'],
          $resultat['role']
        );
      }
      
      return null;
    } catch (PDOException $e) {
      error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
      return null;
    }
  }

  /**
     * vérifie si les identifiant passés en paramètres sont valides
     * @param $email    adresse email du supposé compte
     * @param $motDePasse    mot de passe sans sel ni poivre ni ash du supposé compte
     * @return $unObjUtilisateur    objet utilisateur du compte trouvé
     * @return false    retourne false si identifiants incorrects
     */
    public function verifConnection($email, $motDePasse){
        if($this->existeDeja($email)){ //si l'email appartient bien à un utilisateur, alors on vérifie le mot de passe

            // Charger le poivre depuis le fichier .env
            $poivre = getenv('APP_POIVRE');
            if (!$poivre) {
                error_log("Erreur : Poivre non trouvé dans le fichier .env");
                return false;
            }
            $motDePasseAvecPoivre = $motDePasse . $poivre;

            $ordreSQL = "SELECT motDePasse FROM Utilisateur WHERE mail = :email"; //récupération du hash de mot de passe stocké
            $reqPrepa = $this->prepare($ordreSQL);
            $reqPrepa->bindParam(':email', $email);
            $reqPrepa->execute();
            $resultatDeLaRequete = $reqPrepa->fetch();

            if ($resultatDeLaRequete) {
                $motDePasseStocke = $resultatDeLaRequete['motDePasse'];
    
                if (password_verify($motDePasseAvecPoivre, $motDePasseStocke)) { //vérifie si le mot de passe est correct, alors on récupère les informations de l'utilisateur

                    $ordreSQL = "SELECT * FROM Utilisateur WHERE mail = :email";
                    $reqPrepa = $this->prepare($ordreSQL);
                    $reqPrepa->bindParam(':email', $email);
                    $reqPrepa->execute();
                    $unUtilisateur = $reqPrepa->fetch();
    
                    $unObjUtilisateur = new Utilisateur(
                        $unUtilisateur['id'],
                        $unUtilisateur['mail'],
                        $unUtilisateur['motDePasse'],
                        $unUtilisateur['role']
                    );
    
                    return $unObjUtilisateur;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * modifie le mot de passe d'un utilisateur à partir des informations fournies par le formualire v_formulaireChangerMotDePasse.php
     * @param Utilisateur $unUtilisateur    objet utilisateur contenant les informations nécessaire pour changer le mot de passe au bon utilisateur
     * @param String $nouveauMotDePasse    nouveau mot de passe qui va remplacer l'ancien
     * @return $resultatDeLaRequete    retourne une valeur numérique indiquant si le mot de passe a bien été modifié
     */
    public function editMotDePasse($unUtilisateur, $ancienMotDePasse, $nouveauMotDePasse){
      try {
        // Récupérer les données de l'utilisateur
        $email = $unUtilisateur->getMail();
        $role = $unUtilisateur->getRole();

        $ordreSQL = "SELECT motDePasse FROM Utilisateur WHERE mail = :email"; //récupération du hash de mot de passe stocké
        $reqPrepa = $this->prepare($ordreSQL);
        $reqPrepa->bindParam(':email', $email);
        $reqPrepa->execute();
        $resultatDeLaRequete = $reqPrepa->fetch();

        if ($resultatDeLaRequete) {
          $motDePasseStocke = $resultatDeLaRequete['motDePasse'];

          // Charger le poivre depuis le fichier .env
          $poivre = getenv('APP_POIVRE');
          if (!$poivre) {
              error_log("Erreur : Poivre non trouvé dans le fichier .env");
              return false;
          }

          // Concaténer le mot de passe avec le poivre
          $motDePasseAvecPoivre = $ancienMotDePasse . $poivre;

          if (password_verify($motDePasseAvecPoivre, $motDePasseStocke)) {
            // Hasher le mot de passe avec le poivre
            $nouveauMotDePasseAvecPoivre = $nouveauMotDePasse . $poivre;
            $motDePasseHashe = password_hash($nouveauMotDePasseAvecPoivre, PASSWORD_DEFAULT);

            // Préparer la requête SQL
            $ordreSQL = "UPDATE Utilisateur
                        SET motDePasse = :motDePasse
                        WHERE mail = :email AND role = :role";
            
            $reqPrepa = $this->prepare($ordreSQL);

            // Lier les paramètres
            $reqPrepa->bindParam(':email', $email);
            $reqPrepa->bindParam(':motDePasse', $motDePasseHashe);
            $reqPrepa->bindParam(':role', $role);

            // Exécuter la requête
            $resultatDeLaRequete = $reqPrepa->execute();

            return $resultatDeLaRequete;
          }else{
            echo "L'ancien mot de passe n'est pas le bon.";
            return false;
          }
        }
      } catch (PDOException $e) {
          error_log("Erreur lors de la modification du mot de passe : " . $e->getMessage());
          return false;
      }
    }
    
}