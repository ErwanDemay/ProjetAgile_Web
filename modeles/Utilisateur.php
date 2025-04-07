<?php
Class Utilisateur{
  private $id;
  private $mail;
  private $motDePasse;
  private $role;
  
  public function __construct($id, $mail, $motDePasse, $role){
    $this->id = $id;
    $this->mail = $mail;
    $this->motDePasse = $motDePasse;
    $this->role = $role;
  }
  
  // Getters
  public function getId() {
    return $this->id;
  }
  
  public function getMail() {
    return $this->mail;
  }
  
  public function getMotDePasse() {
    return $this->motDePasse;
  }
  
  public function getRole() {
    return $this->role;
  }
  
  // Setters
  public function setMail($mail) {
    $this->mail = $mail;
  }
  
  public function setMotDePasse($motDePasse) {
    $this->motDePasse = $motDePasse;
  }
  
  public function setRole($role) {
    $this->role = $role;
  }
}



?>