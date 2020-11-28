<?php

require_once("storage/bdd/BDDActiviteStorage.php");
require_once("storage/bdd/BDDRoleStorage.php");
require_once("storage/bdd/BDDUtilisateurStorage.php");

class StorageFactory {

    private static $instance;

    private $storageType;
    private $bdd;

    private function __construct() {

    }

    public static function getInstance() {
        if(StorageFactory::$instance == null) {
            StorageFactory::$instance = new StorageFactory();
        }

        return StorageFactory::$instance;
    }

    public function getBdd() {
        if($this->bdd == null) {
            try {
                $this->bdd = new PDO('mysql:host='.BDD_HOST.':'.BDD_PORT.';dbname='.BDD_NAME, BDD_USER, BDD_PASSWORD);
            } catch (PDOException $e) {
                echo "Erreur !: " . $e->getMessage();
                die();
            }
        }

        return $this->bdd;        
    }

    public function getActiviteStorage($storageType=null) {
        $store = ($storageType != null) ? $storageType : $this->storageType;

        if($store == STORAGE_BDD) {
            return new BDDActiviteStorage($this->getBdd());
        } elseif($store == STORAGE_STUB) {
            return new StubActiviteStorage();
        } else {
            echo "Storage activité en " . $store . " non disponible";
            die();
        }
    }

    public function getRoleStorage($storageType=null) {
        $store = ($storageType != null) ? $storageType : $this->storageType;

        if($store == STORAGE_BDD) {
            return new BDDRoleStorage($this->getBdd());
        } else {
            echo "Storage role en " . $store . " non disponible";
            die();
        }
    }

    public function getUtilisateurStorage($storageType=null) {
        $store = ($storageType != null) ? $storageType : $this->storageType;

        if($store == STORAGE_BDD) {
            return new BDDUtilisateurStorage($this->getBdd());
        } else {
            echo "Storage utilisateur en " . $store . " non disponible";
            die();
        }
    }

    public function setStorageType($storageType) {
        $this->storageType = $storageType;
    }

    public function getStorageType() {
        return $this->storageType;
    }

}