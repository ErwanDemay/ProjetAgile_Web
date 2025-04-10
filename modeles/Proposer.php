<?php

class Proposer {
    private $idRecette;
    private $idSession;

    // Constructeur
    public function __construct($idRecette, $idSession) {
        $this->idRecette = $idRecette;
        $this->idSession = $idSession;
    }

    // Getters et setters
    public function getIdRecette() {
        return $this->idRecette;
    }

    public function setIdRecette($idRecette) {
        $this->idRecette = $idRecette;
    }

    public function getIdSession() {
        return $this->idSession;
    }

    public function setIdSession($idSession) {
        $this->idSession = $idSession;
    }

}

?>
