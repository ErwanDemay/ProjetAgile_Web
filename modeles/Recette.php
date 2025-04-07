<?php
 class Recette {
  private $id;
  private $libelle;
  private $description;
  private $uneImage;
  private $dateAjout;
  private $id_Type;

  public function __construct($id,$libelle,$description,$uneImage,$dateAjout,$id_Type){
    $this->id = $id;
    $this->libelle = $libelle;
    $this->description = $description;
    $this->uneImage = $uneImage;
    $this->dateAjout = $dateAjout;
    $this->id_Type = $id_Type;
  }

  // Getters
  public function getId() {
    return $this->id;
  }

  public function getLibelle() {
    return $this->libelle;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getUneImage() {
    return $this->uneImage;
  }

  public function getDateAjout() {
    return $this->dateAjout;
  }

  public function getId_Type() {
    return $this->id_Type;
  }

  // Setters
  public function setLibelle($libelle) {
    $this->libelle = $libelle;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function setUneImage($uneImage) {
    $this->uneImage = $uneImage;
  }

  public function setDateAjout($dateAjout) {
    $this->dateAjout = $dateAjout;
  }

  public function setId_Type($id_Type) {
    $this->id_Type = $id_Type;
  }
}


?>