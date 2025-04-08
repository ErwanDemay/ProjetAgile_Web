<?php
// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");
include_once (__DIR__ . "/../Session.php");
class SessionDAO extends Base{
    
    /**
     * Constructeur initialisant la connection avec le SGBD grâce à la classe Base, héritée
     */
    public function __construct(){
        parent::__construct();
        parent::setConnexionBase();
    }
    
    /**
     * Récupère toutes les sessions pour les afficher
     * @param
     * @return $lesObjSessions   collection de toutes les sessions sous forme d'objets session
     */
    public function getLesSessions(){
        $ordreSQL = "SELECT * FROM Session;";
        $reqPrepa = $this->prepare($ordreSQL);
        $reqPrepa->execute();
    
        $tableauSessions = $reqPrepa->fetchAll(); // Suppression du fetch() avant fetchAll()
    
        if (count($tableauSessions) == 0) {
            return null; // Si aucune session n'est trouvée
        }
    
        $lesObjSessions = array();
        foreach($tableauSessions as $uneLigneUneSession){
            $uneSession = new Session(
                $uneLigneUneSession["id"],
                $uneLigneUneSession["nomSession"],
                $uneLigneUneSession["dateSession"],
                $uneLigneUneSession["heureDebut"],
                $uneLigneUneSession["heureFin"],
                $uneLigneUneSession["prix"],
                $uneLigneUneSession["nbPlaces"]
            );
            $lesObjSessions[] = $uneSession;
        }
    
        return $lesObjSessions;
    }    
}

/**
 * Retourne le nombre de places restantes d'une session donnée
 * @param $session    objet session dont on cherche le nombre de places restantes
 * @return int        entier correspondant au nombre de places restantes
 */
public function getNbPlacesRestantes($session) {
    // 1. Récupère le nombre de places réservées par les utilisateurs
    $ordreSQL = "SELECT SUM(r.nbPlacesReservees) AS placesReservees
                 FROM Reserver r
                 INNER JOIN Session s ON s.id = r.id_Session
                 WHERE s.id = :id";

    $reqPrepa = $this->prepare($ordreSQL);
    $id = $session->getId();
    $reqPrepa->bindParam(':id', $id);
    $reqPrepa->execute();
    $resultatDeLaRequete = $reqPrepa->fetch(); 

    // Si des réservations existent, on récupère le total des places réservées
    $placesReservees = $resultatDeLaRequete['placesReservees'] ? (int) $resultatDeLaRequete['placesReservees'] : 0;

    // 2. Récupère le nombre total de places dans la session
    $ordreSQL = "SELECT nbPlaces AS placesTotales
                 FROM Session
                 WHERE id = :id";

    $reqPrepa = $this->prepare($ordreSQL);
    $reqPrepa->bindParam(':id', $id);
    $reqPrepa->execute();
    $resultatDeLaRequete = $reqPrepa->fetch();

    // Si le nombre total de places existe, on calcule les places restantes
    if ($resultatDeLaRequete) {
        $placesTotales = (int) $resultatDeLaRequete['placesTotales'];
        // Nombre de places restantes = nombre total de places - places réservées
        $placesRestantes = $placesTotales - $placesReservees;
        return $placesRestantes >= 0 ? $placesRestantes : 0;  // En cas de nombre négatif, on retourne 0
    } else {
        return 0;  // Si la session n'existe pas ou il y a une erreur, on retourne 0
    }
}

?>