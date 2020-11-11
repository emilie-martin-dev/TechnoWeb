<?php

require_once("storage/IActiviteStorage.php");
require_once("model/Activite.php");

class BDDActiviteStorage implements IActiviteStorage {

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
        $sth = $this->bdd->prepare("SELECT * FROM ACTIVITE WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();
        
        $builder = new BuilderActivite($sth->fetch(PDO::FETCH_ASSOC)); 
            
        return $builder->create();
    }
    
    public function readByName($name) {
        $sth = $this->bdd->prepare("SELECT * FROM ACTIVITE WHERE NOM = :nom");
        $sth->bindValue(":nom", $name);
        $sth->execute();
        
        $builder = new BuilderActivite($sth->fetch(PDO::FETCH_ASSOC)); 
            
        return $builder->create();
    }

    public function readAll() {
        $sth = $this->bdd->prepare("SELECT * FROM ACTIVITE ORDER BY NOM");
        $sth->execute();
        
        $activites = array();
        
        foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $builder = new BuilderActivite($r); 
            $activites[] = $builder->create();
        }
        
        return $activites;
    }

    public function create(Activite $a) {
        $sth = $this->bdd->prepare("INSERT INTO ACTIVITE VALUES(NULL, :nom, :lieu, :short_desc, :desc, :id_utilisateur)");
        $sth->bindValue(":nom", $a->getNom());
        $sth->bindValue(":lieu", $a->getLieu());
        $sth->bindValue(":short_desc", $a->getShortDescription());
        $sth->bindValue(":desc", $a->getDescription());
        $sth->bindValue(":id_utilisateur", 1, PDO::PARAM_INT);
        
        $sth->execute();
    }

    public function update($id, Activite $activite) {
        $sth = $this->bdd->prepare("UPDATE ACTIVITE SET NOM=:nom, LIEU=:lieu, SHORT_DESCRIPTION=:short_desc, DESCRIPTION=:desc WHERE ID=:id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->bindValue(":nom", $activite->getNom());
        $sth->bindValue(":lieu", $activite->getLieu());
        $sth->bindValue(":short_desc", $activite->getShortDescription());
        $sth->bindValue(":desc", $activite->getDescription());

        $sth->execute();
    }

    public function delete($id) {
        $sth = $this->bdd->prepare("DELETE FROM ACTIVITE WHERE ID=:id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
       
        $sth->execute();
    }

}