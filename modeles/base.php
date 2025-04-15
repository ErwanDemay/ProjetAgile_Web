<?php
class Base {
   protected PDO $db;

   protected $poivre;
 
   protected function __construct() {
        // Chargement des variables d'environnement
        $this->chargerVariablesEnvironnement();
        $this->poivre = getenv('APP_POIVRE');
   }

   

   private function chargerVariablesEnvironnement() {
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    putenv("$key=$value");
                }
            }
        }
   }

  /**
 * La fonction `setConnexionBase` établit une connexion à une base de données MySQL en utilisant des variables
 * d'environnement pour l'hôte, le nom de la base de données, l'utilisateur et le mot de passe.
 * 
 * @return La fonction `setConnexionBase()` retourne une valeur booléenne `true` si la connexion à la base de données
 * est établie avec succès.
 */
    protected function setConnexionBase() {         
        try {
            $host = getenv('DB_HOST');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');

            $this->db = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $password);
            $this->db->query("SET CHARACTER SET utf8");
            return true;
        }
        catch (PDOException $erreur) {
            die("Erreur de connexion à la base de données ".$erreur->getMessage());
        }
    }

    /**
     * Teste la connexion à la base de données
     * @return array Tableau contenant le statut de la connexion et un message
     */
    public function testerConnexion() {
        try {
            $this->setConnexionBase();
            // Test simple : on essaie de faire une requête
            $this->db->query("SELECT 1");
            return [
                'success' => true,
                'message' => 'Connexion à la base de données réussie !'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur de connexion : ' . $e->getMessage()
            ];
        }
    }
    
    protected function query(string $sql) {
        return $this->db->query($sql);
    }
    
    protected function exec(string $sql) {
        return $this->db->exec($sql);
    }

    protected function prepare(string $sql) {
        return $this->db->prepare($sql);
    }

    /**
     * retourne le poivre commun à toute l'application
     * @param
     * @return $poivre    retourne la chaîne de caractères servant de poivre
     */
    protected function getPoivre() {
        return $this->poivre;
    }
}

