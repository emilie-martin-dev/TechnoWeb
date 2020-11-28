<?php

require_once("storage/IUtilisateurStorage.php");
require_once("model/builder/BuilderUtilisateur.php");
require_once("model/Utilisateur.php");

class BDDUtilisateurStorage implements IUtilisateurStorage {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
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