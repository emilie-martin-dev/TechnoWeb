<?php

require_once("storage/IRoleStorage.php");
require_once("model/builder/BuilderRole.php");
require_once("model/Role.php");

class BDDRoleStorage implements IRoleStorage {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function read($id) {
        $sth = $this->bdd->prepare("SELECT * FROM ROLE WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();

        $builder = new BuilderRole($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }

    public function readLibelle($libelle) {

        $sth = $this->bdd->prepare("SELECT * FROM ROLE WHERE LIBELLE = :libelle");
        $sth->bindValue(":libelle", $libelle);
        $sth->execute();

        $builder = new BuilderRole($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }

}
