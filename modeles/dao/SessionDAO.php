<?php
// Include de la classe Base qui contient la connexion
include_once (__DIR__ . "/../Base.php");
include_once (__DIR__ . "/../Session.php");
include_once (__DIR__ . "/../dao/ProposerDAO.php");
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
        try {
        $ordreSQL = "SELECT * FROM Session";
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
    catch (PDOException $e){
        error_log("erreur lors de la récupération des sessions" . $e->getMessage());
        return[];
    }
    }    


/**
 * Retourne le nombre de places restantes d'une session donnée
 * @param $Session    objet session dont on cherche le nombre de places restantes
 * @return int        entier correspondant au nombre de places restantes
 */
public function getNbPlacesRestantes($Session) {
    // Récupération de l'ID de la session
    $id = $Session->getId();

    // 1. Compter le nombre de réservations pour cette session
    $ordreSQL = "SELECT COUNT(*) AS placesReservees
                 FROM Reserver
                 WHERE id = :id";

    $reqPrepa = $this->prepare($ordreSQL);
    $reqPrepa->bindParam(':id', $id);
    $reqPrepa->execute();
    $resultat = $reqPrepa->fetch();

    $placesReservees = isset($resultat['placesReservees']) ? (int) $resultat['placesReservees'] : 0;

    // 2. Récupérer le nombre total de places dans la session
    $ordreSQL = "SELECT nbPlaces AS placesTotales
                 FROM Session
                 WHERE id = :id";

    $reqPrepa = $this->prepare($ordreSQL);
    $reqPrepa->bindParam(':id', $id);
    $reqPrepa->execute();
    $resultat = $reqPrepa->fetch();

    if ($resultat) {
        $placesTotales = (int) $resultat['placesTotales'];
        $placesRestantes = $placesTotales - $placesReservees;
        return $placesRestantes >= 0 ? $placesRestantes : 0;
    } else {
        return 0;
    }
}

public function ajoutSession($nomSession, $dateSession, $heureDebut, $heureFin, $prix, $nbPlaces) {
    try {
        // Préparation de la requête d'insertion
        $sql = "INSERT INTO Session (nomSession, dateSession, heureDebut, heureFin, prix, nbPlaces) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        // Préparation de la requête SQL
        $stmt = $this->prepare($sql);
        
        // Exécution de la requête avec les paramètres
        $resultat = $stmt->execute([
            $nomSession,  // Nom de la session
            $dateSession, // Date de la session (format: YYYY-MM-DD)
            $heureDebut,  // Heure de début de la session (format: HH:MM:SS)
            $heureFin,    // Heure de fin de la session (format: HH:MM:SS)
            $prix,        // Prix de la session
            $nbPlaces     // Nombre de places disponibles
        ]);

        return $resultat;
    } catch (PDOException $e) {
        // Log de l'erreur (à implémenter selon vos besoins)
        error_log("Erreur lors de l'ajout de la session : " . $e->getMessage());
        return false;
    }
}

public function supprimerSession($id) {
    try {
        // Préparation de la requête de suppression
        $sql = "DELETE FROM Session WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->prepare($sql);

        // Exécution de la requête avec l'ID de la session à supprimer
        $resultat = $stmt->execute([$id]);

        return $resultat;
    } catch (PDOException $e) {
        // Log de l'erreur (à implémenter selon vos besoins)
        error_log("Erreur lors de la suppression de la session : " . $e->getMessage());
        return false;
    }
}

public function getUneSession($id) {
    try {
        $sql = "SELECT * FROM Session WHERE id = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$id]);

        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultat) {
            return new Session(
                $resultat['id'],
                $resultat['nomSession'],
                $resultat['dateSession'],
                $resultat['heureDebut'],
                $resultat['heureFin'],
                $resultat['prix'],
                $resultat['nbPlaces']
            );
        }

        return null;
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de la session : " . $e->getMessage());
        return null;
    }
}

public function updateSession($laSession) {
    try {
        $sql = "UPDATE Session 
                SET nomSession = ?, dateSession = ?, heureDebut = ?, heureFin = ?, prix = ?, nbPlaces = ? 
                WHERE id = ?";
        
        $stmt = $this->prepare($sql);

        $resultat = $stmt->execute([
            $laSession->getNomSession(),
            $laSession->getDateSession(),
            $laSession->getHeureDebut(),
            $laSession->getHeureFin(),
            $laSession->getPrix(),
            $laSession->getNbPlaces(),
            $laSession->getId()
        ]);

        return $resultat;
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour de la session : " . $e->getMessage());
        return false;
    }
}

public function getLesRecettesDeLaSession($idSession) {
    // Préparer la requête SQL pour récupérer les recettes associées à la session
    $query = "SELECT r.id, r.libelle, r.description, r.uneImage, r.dateAjout
              FROM Recette r
              JOIN Proposer p ON r.id = p.id
              WHERE p.id_Session = :idSession";

    // Préparer la requête avec la connexion
    $stmt = $this->prepare($query);
    $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si des recettes ont été trouvées
    if ($recettes) {
        return $recettes;
    } else {
        return null; // Retourne null si aucune recette n'est trouvée
    }
}

public function getSessionsByRecette($idRecette) {
    $sql = "SELECT Session.* 
            FROM Session
            INNER JOIN Proposer ON Session.id = Proposer.id_Session
            WHERE Proposer.id = :idRecette";
    
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':idRecette', $idRecette, PDO::PARAM_INT);
    $stmt->execute();

    $sessions = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sessions[] = new Session(
            $row['id'],
            $row['nomSession'],
            $row['dateSession'],
            $row['heureDebut'],
            $row['heureFin'],
            $row['prix'],
            $row['nbPlaces']
        );
    }

    return $sessions;
}

}
?>