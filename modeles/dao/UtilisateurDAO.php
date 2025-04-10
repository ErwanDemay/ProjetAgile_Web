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
    
}

