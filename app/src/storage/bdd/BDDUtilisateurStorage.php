<?php

require_once("storage/IUtilisateurStorage.php");
require_once("model/builder/BuilderUtilisateur.php");
require_once("model/Utilisateur.php");

class BDDUtilisateurStorage implements IUtilisateurStorage {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function create(Utilisateur $utilisateur) {
        $sth = $this->bdd->prepare("INSERT INTO UTILISATEUR VALUES(NULL, :nom, :prenom, :login, :password, :role)");
        $sth->bindValue(":nom", $utilisateur->getNom());
        $sth->bindValue(":prenom", $utilisateur->getPrenom());
        $sth->bindValue(":login", $utilisateur->getLogin());
        $sth->bindValue(":password", password_hash($utilisateur->getPassword(), PASSWORD_BCRYPT));
        $sth->bindValue(":role", $utilisateur->getRole()->getId(), PDO::PARAM_INT);

        $sth->execute();

        return $this->bdd->lastInsertId();
    }

    public function readByLogin($login) {
        $sth = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE LOGIN = :login");
        $sth->bindValue(":login", $login);
        $sth->execute();

        $builder = new BuilderUtilisateur($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }
    
    public function read($id) {
        $sth = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();

        $builder = new BuilderUtilisateur($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }

    public function checkAuth($login, $password) {
        $sth = $this->bdd->prepare("SELECT * FROM UTILISATEUR WHERE LOGIN = :login");
        $sth->bindValue(":login", $login);
        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_ASSOC);

        $builder = new BuilderUtilisateur($data);
        $utilisateur = $builder->create();

        if($utilisateur == null || !password_verify($password, $utilisateur->getPassword()))
            return null;

        return $utilisateur;
    }

}
