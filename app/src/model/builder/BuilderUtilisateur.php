<?php

require_once("model/builder/AbstractBuilder.php");
require_once("model/Utilisateur.php");
require_once("model/Role.php");

class BuilderUtilisateur extends AbstractBuilder {

    const FIELD_ID = "ID";
    const FIELD_NOM = "NOM";
    const FIELD_PRENOM = "PRENOM";
    const FIELD_LOGIN = "LOGIN";
    const FIELD_PASSWORD = "PASSWORD";
    const FIELD_ID_ROLE = "ID_ROLE";

    public function __construct($data, $error = null) {
        parent::__construct($data, $error);
    }

	public static function buildFromUtilisateur(Utilisateur $Utilisateur) {
		return new BuilderUtilisateur(array(
			BuilderUtilisateur::FIELD_ID => $Utilisateur->getId(),
			BuilderUtilisateur::FIELD_NOM => $Utilisateur->getNom(),
			BuilderUtilisateur::FIELD_PRENOM => $Utilisateur->getPrenom(),
			BuilderUtilisateur::FIELD_LOGIN => $Utilisateur->getLogin(),
			BuilderUtilisateur::FIELD_PASSWORD => $Utilisateur->getPassword(),
			BuilderUtilisateur::FIELD_ID_ROLE => $Utilisateur->getRole()->getId()
		));
	}

    public function createModel() {

        $u = new Utilisateur();

        if(isset($this->data[BuilderUtilisateur::FIELD_ID]))
            $u->setId($this->data[BuilderUtilisateur::FIELD_ID]);

        $u->setNom($this->data[BuilderUtilisateur::FIELD_NOM]);
        $u->setPrenom($this->data[BuilderUtilisateur::FIELD_PRENOM]);
        $u->setLogin($this->data[BuilderUtilisateur::FIELD_LOGIN]);
        $u->setPassword($this->data[BuilderUtilisateur::FIELD_PASSWORD]);
        $u->setRole(new Role($this->data[BuilderUtilisateur::FIELD_ID_ROLE]));

        return $u;
    }

    public function isValid() {
        $this->error = array();

        if(isset($this->data[BuilderUtilisateur::FIELD_ID]) && !is_numeric($this->data[BuilderUtilisateur::FIELD_ID])) {
            $this->error[BuilderUtilisateur::FIELD_ID] = "La valeur de l'id est incorrect";
        }

        if(empty($this->data[BuilderUtilisateur::FIELD_NOM])) {
            $this->error[BuilderUtilisateur::FIELD_NOM] = "Le nom est obligatoire";
        }

        if(empty($this->data[BuilderUtilisateur::FIELD_PRENOM])) {
            $this->error[BuilderUtilisateur::FIELD_PRENOM] = "Le prénom est obligatoire";
        }

        if(empty($this->data[BuilderUtilisateur::FIELD_LOGIN])) {
            $this->error[BuilderUtilisateur::FIELD_LOGIN] = "Le login est obligatoire";
        }

        if(empty($this->data[BuilderUtilisateur::FIELD_PASSWORD])) {
            $this->error[BuilderUtilisateur::FIELD_PASSWORD] = "Le mot de passe est obligatoire";
        }

        if(!is_numeric($this->data[BuilderUtilisateur::FIELD_ID_ROLE])) {
            $this->error[BuilderUtilisateur::FIELD_ID_ROLE] = "L'id de role est incorrect";
        }

        return count($this->error) == 0;
    }

}
