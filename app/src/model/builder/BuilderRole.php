<?php

require_once("model/builder/AbstractBuilder.php");
require_once("model/Role.php");

class BuilderRole extends AbstractBuilder {

    const FIELD_ID = "ID"; 
    const FIELD_LIBELLE = "LIBELLE"; 

    public function __construct($data, $error = null) {
        parent::__construct($data, $error);
    }

	public static function buildFromUtilisateur(Role $Utilisateur) {
		return new BuilderRole(array(
			BuilderRole::FIELD_ID => $Utilisateur->getId(),
			BuilderRole::FIELD_LIBELLE => $Utilisateur->getLibelle()
		));
	}

    public function create() {
        if($this->data == null || $this->data != null && !$this->isValid())
            return null;
        
        $r = new Role();
        
        if(isset($this->data[BuilderRole::FIELD_ID]))
            $r->setId($this->data[BuilderRole::FIELD_ID]);
            
        $r->setLibelle($this->data[BuilderRole::FIELD_LIBELLE]);

        return $r;
    }
    
    public function isValid() {
        $this->error = array();

        if(isset($this->data[BuilderRole::FIELD_ID]) && !is_numeric($this->data[BuilderRole::FIELD_ID])) {
            $this->error[BuilderRole::FIELD_ID] = "La valeur de l'id est incorrect";
        }
        
        if(empty($this->data[BuilderRole::FIELD_LIBELLE])) {
            $this->error[BuilderRole::FIELD_LIBELLE] = "Le libelle est obligatoire";
        }

        return count($this->error) == 0;
    }

}