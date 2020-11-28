<?php

require_once("model/builder/AbstractBuilder.php");
require_once("model/Activite.php");

class BuilderActivite extends AbstractBuilder {

    const FIELD_ID = "ID";
    const FIELD_NOM = "NOM";
    const FIELD_LIEU = "LIEU";
    const FIELD_SHORT_DESCRIPTION = "SHORT_DESCRIPTION";
    const FIELD_DESCRIPTION = "DESCRIPTION";
    const FIELD_ID_UTILISATEUR = "ID_UTILISATEUR";

    public function __construct($data, $error = null) {
        parent::__construct($data, $error);
    }

	public static function buildFromActivite(Activite $activite) {
		return new BuilderActivite(array(
			BuilderActivite::FIELD_ID => $activite->getId(),
			BuilderActivite::FIELD_NOM => $activite->getNom(),
			BuilderActivite::FIELD_LIEU => $activite->getLieu(),
			BuilderActivite::FIELD_SHORT_DESCRIPTION => $activite->getShortDescription(),
			BuilderActivite::FIELD_DESCRIPTION => $activite->getDescription(),
			BuilderActivite::FIELD_ID_UTILISATEUR => $activite->getUtilisateur()->getId()
		));
	}

    public function createModel() {

        $a = new Activite();

        if(isset($this->data[BuilderActivite::FIELD_ID]))
            $a->setId($this->data[BuilderActivite::FIELD_ID]);

        $a->setNom($this->data[BuilderActivite::FIELD_NOM]);
        $a->setLieu($this->data[BuilderActivite::FIELD_LIEU]);
        $a->setDescription($this->data[BuilderActivite::FIELD_SHORT_DESCRIPTION]);
        $a->setShortDescription($this->data[BuilderActivite::FIELD_SHORT_DESCRIPTION]);
        $a->setUtilisateur(new Utilisateur($this->data[BuilderActivite::FIELD_ID_UTILISATEUR]));

        return $a;
    }

    public function isValid() {
        $this->error = array();

        if(isset($this->data[BuilderActivite::FIELD_ID]) && !is_numeric($this->data[BuilderActivite::FIELD_ID])) {
            $this->error[BuilderActivite::FIELD_ID] = "La valeur de l'id est incorrect";
        }

        if(empty($this->data[BuilderActivite::FIELD_NOM])) {
            $this->error[BuilderActivite::FIELD_NOM] = "Le nom est obligatoire";
        }

        if(empty($this->data[BuilderActivite::FIELD_LIEU])) {
            $this->error[BuilderActivite::FIELD_LIEU] = "Le lieu est obligatoire";
        }

        if(empty($this->data[BuilderActivite::FIELD_SHORT_DESCRIPTION])) {
            $this->error[BuilderActivite::FIELD_SHORT_DESCRIPTION] = "La courte description est obligatoire";
        }

        if(empty($this->data[BuilderActivite::FIELD_DESCRIPTION])) {
            $this->error[BuilderActivite::FIELD_DESCRIPTION] = "La description est obligatoire";
        }

        if(!is_numeric($this->data[BuilderActivite::FIELD_ID_UTILISATEUR])) {
            $this->error[BuilderActivite::FIELD_ID_UTILISATEUR] = "L'id de l'utilisateur est incorrect";
        }

        return count($this->error) == 0;
    }

}
