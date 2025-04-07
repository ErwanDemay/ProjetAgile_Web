<?php
include_once ("./modeles/Base.php");
class UtilisateurDAO extends Base{

  /**
     * TODO: Créer une méthode pour la connexion d'un utilisateur
     * @param string $email - Email de l'utilisateur
     * @param string $password - Mot de passe en clair
     * @return array|null - Données de l'utilisateur si connexion réussie, null sinon
     */
    // public function connecterUtilisateur($email, $password) {}

    /**
     * TODO: Créer une méthode pour générer un sel unique
     * @return string - Sel généré
     */
    // private function genererSel() {}

    /**
     * TODO: Créer une méthode pour hacher le mot de passe avec sel et poivre
     * @param string $password - Mot de passe en clair
     * @param string $sel - Sel unique pour l'utilisateur
     * @return string - Mot de passe haché
     */
    // private function hasherMotDePasse($password, $sel) {}
    
   
    /**
     * TODO: Créer une méthode pour vérifier si un email existe déjà
     * @param string $email - Email à vérifier
     * @return bool - True si l'email existe déjà, false sinon
     */
    // public function emailExiste($email) {}

    /**
     * TODO: Créer une méthode pour vérifier un mot de passe
     * @param string $password - Mot de passe à vérifier
     * @param string $hashStocke - Hash stocké en base
     * @param string $sel - Sel stocké en base
     * @return bool - True si le mot de passe correspond, false sinon
     */
    // private function verifierMotDePasse($password, $hashStocke, $sel) {}

    
    /**
     * TODO: Créer une méthode pour récupérer les informations d'un utilisateur
     * @param int $id - ID de l'utilisateur
     * @return array|null - Données de l'utilisateur ou null si non trouvé
     */
    // public function getUtilisateurById($id) {}

    /**
     * TODO: Créer une méthode pour mettre à jour les informations d'un utilisateur
     * @param int $id - ID de l'utilisateur
     * @param array $donnees - Nouvelles données de l'utilisateur
     * @return bool - True si la mise à jour est réussie, false sinon
     */
    // public function mettreAJourUtilisateur($id, $donnees) {}

}