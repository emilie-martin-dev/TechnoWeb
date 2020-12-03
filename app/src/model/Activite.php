<?php

require_once("model/Utilisateur.php");

class Activite {

    private $id;
    private $nom;
    private $lieu;
    private $description;
    private $shortDescription;
    private $utilisateur;

    public function __construct($id=-1) {
        $this->setId($id);
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

    public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur) {
        $this->utilisateur = $utilisateur;
    }

}
