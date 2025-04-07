<?php
class Session{
  private $id;
  private $nomSession;
  private $dateSession;
  private $heureDebut;
  private $heureFin;
  private $prix;
  private $nbPlaces;
  
  public function __construct($id, $nomSession, $dateSession, $heureDebut, $heureFin, $prix, $nbPlaces){
    $this->id = $id;
    $this->nomSession = $nomSession;
    $this->dateSession = $dateSession;
    $this->heureDebut = $heureDebut;
    $this->heureFin = $heureFin;
    $this->prix = $prix;
    $this->nbPlaces = $nbPlaces;
  }
  
  // Getters
  public function getId() {
    return $this->id;
  }
  
  public function getNomSession() {
    return $this->nomSession;
  }
  
  public function getDateSession() {
    return $this->dateSession;
  }
  
  public function getHeureDebut() {
    return $this->heureDebut;
  }
  
  public function getHeureFin() {
    return $this->heureFin;
  }
  
  public function getPrix() {
    return $this->prix;
  }
  
  public function getNbPlaces() {
    return $this->nbPlaces;
  }
  
  // Setters
  public function setNomSession($nomSession) {
    $this->nomSession = $nomSession;
  }
  
  public function setDateSession($dateSession) {
    $this->dateSession = $dateSession;
  }
  
  public function setHeureDebut($heureDebut) {
    $this->heureDebut = $heureDebut;
  }
  
  public function setHeureFin($heureFin) {
    $this->heureFin = $heureFin;
  }
  
  public function setPrix($prix) {
    $this->prix = $prix;
  }
  
  public function setNbPlaces($nbPlaces) {
    $this->nbPlaces = $nbPlaces;
  }
}
?>