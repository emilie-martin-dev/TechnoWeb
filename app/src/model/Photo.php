<?php

class Photo {

    private $id;
    private $chemin;
    private $activite;

    public function __construct($id=-1) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getChemin() {
        return $this->chemin;
    }

    public function setChemin($chemin) {
        $this->chemin = $chemin;
    }

    public function getActivite() {
        return $this->activite;
    }

    public function setActivite($activite) {
        $this->activite = $activite;
    }
}