<?php

class Activite {

    private $id;
    private $nom;
    private $lieu;
    private $description;
    private $shortDescription;

    public function __construct($id, $nom, $lieu) {
        $this->setId($id);
        $this->setNom($nom);
        $this->setLieu($lieu);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getLieu() {
        return $this->lieu;
    }

    public function setLieu($lieu) {
        $this->lieu = $lieu;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getShortDescription() {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }

}