<?php

require_once("model/Utilisateur.php");
require_once("model/Activite.php");

class Comment {

    private $id;
    private $texte;
    private $utilisateur;
    private $activite;

    public function __construct($id=-1) {
        $this->setId($id);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTexte() {
        return $this->texte;
    }

    public function setTexte($texte) {
        $this->texte = $texte;
    }

    public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function getActivite() {
        return $this->activite;
    }

    public function setActivite(Activite $activite) {
        $this->activite = $activite;
    }

}
