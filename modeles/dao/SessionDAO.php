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

/**
 * La fonction "ajoutSession" insère un nouvel enregistrement de session dans une table de base de données avec
 * les détails spécifiés de la session.
 * 
 * @param nomSession Le paramètre `nomSession` représente le nom ou le titre de la session que vous
 * souhaitez ajouter à la base de données. Il peut s'agir d'un nom descriptif qui identifie la session pour
 * les utilisateurs ou les participants. Par exemple, "Introduction à la programmation" ou "Cours de Yoga".
 * @param dateSession Le paramètre `dateSession` représente la date de la session au format
 * `YYYY-MM-DD`, où :
 * @param heureDebut Le paramètre "heureDebut" représente l'heure de début de la session au format
 * HH:MM:SS (heures:minutes:secondes). Par exemple, si une session commence à 9h30, la valeur de
 * "heureDebut" serait '09:30:00'.
 * @param heureFin Le paramètre "heureFin" représente l'heure de fin de la session au format
 * HH:MM:SS (heures:minutes:secondes). Ce paramètre est utilisé dans la fonction pour spécifier l'heure de fin
 * de la session.
 * @param prix Le paramètre "prix" dans la fonction "ajoutSession" représente le prix de la session
 * ajoutée. Il s'agit d'une valeur numérique qui indique le coût ou le prix associé à la participation
 * à la session. Cette valeur est insérée dans la table de base de données avec les autres détails de la session tels que
 * le nom, la date, l'heure, etc.
 * @param nbPlaces Le paramètre `nbPlaces` dans la fonction `ajoutSession` représente le nombre de
 * places disponibles pour la session ajoutée. Il est utilisé pour spécifier le nombre maximal de
 * participants pouvant assister à la session. Cette valeur est généralement un entier représentant
 * la capacité de la session.
 * 
 * @return La fonction `ajoutSession` retourne le résultat de l'exécution de la requête SQL, qui
 * est une valeur booléenne indiquant si l'insertion a été réussie ou non. Si l'insertion a
 * réussi, elle retourne `true`, sinon elle retourne `false`.
 */
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

/**
 * La fonction `supprimerSession` supprime une session d'une table de base de données en fonction de l'ID fourni et
 * retourne un booléen indiquant le succès de l'opération.
 * 
 * @param id Le fragment de code que vous avez fourni est une fonction PHP qui est conçue pour supprimer une session d'une
 * table de base de données en fonction de l'ID de session fourni. La fonction prend l'ID de la session en paramètre
 * et tente de supprimer l'enregistrement de session correspondant de la table "Session".
 * 
 * @return La fonction `supprimerSession` retourne le résultat de l'exécution de la requête de suppression.
 * Si la suppression est réussie, elle retourne `true`, sinon elle intercepte toute `PDOException`
 * qui survient pendant le processus, enregistre le message d'erreur et retourne `false`.
 */
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

/**
 * La fonction `getUneSession` récupère une session de la base de données en fonction de l'ID fourni et
 * la retourne sous forme d'un objet Session, en gérant les éventuelles erreurs.
 * 
 * @param id La fonction `getUneSession` est une méthode PHP qui récupère une session d'une base de données
 * en fonction de l'ID fourni. Elle utilise une requête préparée pour interroger la base de données et récupérer
 * le résultat sous forme de tableau associatif. Si une session est trouvée, elle crée un nouvel objet `Session` avec les
 * données récupérées.
 * 
 * @return La fonction `getUneSession` retourne une instance de la classe `Session` avec les données
 * récupérées de la base de données si un résultat est trouvé en fonction de l'ID fourni. Si aucun résultat n'est trouvé,
 * elle retourne `null`. En cas d'exception pendant l'opération sur la base de données, elle intercepte la
 * `PDOException`, enregistre un message d'erreur, et retourne également `null`.
 */
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

/**
 * La fonction `updateSession` met à jour un enregistrement de session dans une table de base de données en utilisant l'objet session fourni.
 * 
 * @param laSession La fonction `updateSession` que vous avez fournie est responsable de la mise à jour d'une session dans
 * une base de données. Elle prend un objet `laSession` comme paramètre, qui semble représenter une session avec
 * des propriétés comme `nomSession`, `dateSession`, `heureDebut`, `heureFin`, `prix`, etc.
 * 
 * @return La fonction `updateSession` retourne le résultat de l'exécution de la requête SQL de mise à jour.
 * Ce résultat indique si l'opération de mise à jour a réussi ou non. Si la mise à jour est réussie, elle retourne `true`.
 * En cas d'erreur pendant le processus de mise à jour, elle intercepte l'exception, enregistre un message d'erreur et retourne `false`.
 */
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

/**
 * Cette fonction PHP récupère les recettes associées à un ID de session spécifique à partir d'une base de données.
 * 
 * @param idSession Le paramètre `idSession` représente l'ID de la session pour laquelle vous souhaitez
 * récupérer les recettes associées. La fonction `getLesRecettesDeLaSession` prend cet ID de session en entrée,
 * interroge la base de données pour récupérer les recettes associées à cette session, et retourne les résultats
 * sous forme d'un tableau de données de recettes si des recettes sont trouvées.
 * 
 * @return La fonction `getLesRecettesDeLaSession` retourne un tableau de tableaux associatifs contenant
 * les détails des recettes associées à une session spécifique. Si des recettes sont trouvées, la fonction
 * retourne le tableau des recettes. Si aucune recette n'est trouvée, elle retourne `null`.
 */

public function getLesRecettesDeLaSession($idSession) {
    // Préparer la requête SQL pour récupérer les recettes associées à la session
    $query = "SELECT r.id, r.libelle, r.description, r.uneImage, r.dateAjout
              FROM Recette r
              JOIN Proposer p ON r.id = p.idRecette
              WHERE p.idSession = :idSession";

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
            INNER JOIN Proposer ON Session.id = Proposer.idSession
            WHERE Proposer.idRecette = :idRecette";
    
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

public function addReservation($idUtilisateur, $idSession) {
    try {
        $sql = "INSERT INTO Reserver (id, id_Utilisateur) VALUES (:idSession, :idUtilisateur)";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Erreur lors de l'ajout de réservation : " . $e->getMessage());
        return false;
    }
}

public function aReserveSession($idUtilisateur, $idSession) {
    $sql = "SELECT COUNT(*) FROM Reserver WHERE id = :idSession AND id_Utilisateur = :idUtilisateur";
    $stmt = $this->prepare($sql);
    $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);
    $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

public function supprimerReservation($idUtilisateur, $idSession) {
    try {
        $sql = "DELETE FROM Reserver WHERE id = :idSession AND id_Utilisateur = :idUtilisateur";
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':idSession', $idSession, PDO::PARAM_INT);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression de réservation : " . $e->getMessage());
        return false;
    }
}

public function getSessionsReserveesParUtilisateur($idUtilisateur) {
    $sql = "SELECT s.* 
            FROM Session s 
            INNER JOIN Reserver r ON s.id = r.id 
            WHERE r.id_Utilisateur = :idUtilisateur";
    
    $stmt = $this->prepare($sql);
    $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
    $stmt->execute();
    
    $sessions = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $session = new Session(
            $row['id'],
            $row['nomSession'],
            $row['dateSession'],
            $row['heureDebut'],
            $row['heureFin'],
            $row['prix'],
            $row['nbPlaces']
        );
        $sessions[] = $session;
    }

    return $sessions;
}

}
?>