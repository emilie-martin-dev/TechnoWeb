<?php

require_once("storage/IActiviteStorage.php");

class StubActiviteStorage implements IActiviteStorage {

    private $data;

    public function __construct() {
        $this->data = array(
            'mont-saint-michel' => new Activite('mont-saint-michel', 'mont-saint-michel', 'ville du mont-saint-michel'),
            'caen' => new Activite('caen', 'Caen', 'ville'),
            'chemin de fer' => new Activite('chemin de fer', 'Chemin de fer', 'Ancienne ligne de train'),
        );
    } 

    public function read($id) {
        if(array_key_exists($id, $this->data)) 
            return $this->data[$id];

        return null;
    }

    public function readAll() {
        return $this->data;
    }
}