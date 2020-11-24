<?php

require_once("storage/IRoleStorage.php");
require_once("model/builder/BuilderRole.php");
require_once("model/Role.php");

class BDDRoleStorage implements IRoleStorage {

    private $bdd;

    public function __construct() {
        try {
            $this->bdd = new PDO('mysql:host='.BDD_HOST.':'.BDD_PORT.';dbname='.BDD_NAME, BDD_USER, BDD_PASSWORD);
        } catch (PDOException $e) {
            echo "Erreur !: " . $e->getMessage();
            die();
        }
    }
    
    public function read($id) {
        $sth = $this->bdd->prepare("SELECT * FROM ROLE WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();
        
        $builder = new BuilderActivite($sth->fetch(PDO::FETCH_ASSOC)); 
            
        return $builder->create();
    }
}