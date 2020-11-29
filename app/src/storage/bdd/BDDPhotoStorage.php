<?php

require_once("model/Photo.php");
require_once("model/builder/BuilderPhoto.php");
require_once("storage/IPhotoStorage.php");

class BDDPhotoStorage implements IPhotoStorage {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function read($id) {
        $sth = $this->bdd->prepare("SELECT * FROM PHOTO WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();
        
        $builder = new BuilderPhoto($sth->fetch(PDO::FETCH_ASSOC)); 
            
        return $builder->create();
    }

    public function readAllByActiviteId($activiteId) {
        $sth = $this->bdd->prepare("SELECT * FROM PHOTO WHERE ID_ACTIVITE = :idActivite");
        $sth->bindValue(":idActivite", $activiteId, PDO::PARAM_INT);
        $sth->execute();
        
        $activites = array();
        
        foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $builder = new BuilderPhoto($r); 
            $activites[] = $builder->create();
        }
        
        return $activites;
    }

    public function create(Photo $p) {
        $sth = $this->bdd->prepare("INSERT INTO PHOTO VALUES(NULL, :chemin, :id_activite)");
        $sth->bindValue(":chemin", $p->getChemin());
        $sth->bindValue(":id_activite", $p->getActivite()->getId(), PDO::PARAM_INT);
        
        $sth->execute();
        
        return $this->bdd->lastInsertId();
    }

    public function delete($id) {
        $sth = $this->bdd->prepare("DELETE FROM PHOTO WHERE ID=:id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
       
        $sth->execute();
    }

}