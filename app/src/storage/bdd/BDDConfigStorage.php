<?php

require_once("storage/IConfigStorage.php");
require_once("model/Config.php");

class BDDConfigStorage implements IConfigStorage {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function read($id) {
        $sth = $this->bdd->prepare("SELECT * FROM CONFIG WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();

        $builder = new BuilderConfig($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }

    public function readLibelle($libelle) {
        $sth = $this->bdd->prepare("SELECT * FROM CONFIG WHERE LIBELLE = :libelle");
        $sth->bindValue(":libelle", $libelle, PDO::PARAM_INT);
        $sth->execute();

        $builder = new BuilderConfig($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }

    public function updateValeurs($id, Config $config) {
        $sth = $this->bdd->prepare("UPDATE CONFIG SET VALEUR=:valeur WHERE ID=:id");
        $sth->bindValue(":valeur", $config->getValeur(), PDO::PARAM_INT);
        $sth->bindValue(":id", $id, PDO::PARAM_INT);

        $sth->execute();
    }

}
