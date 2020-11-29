<?php

require_once("model/builder/AbstractBuilder.php");
require_once("model/Activite.php");
require_once("model/Photo.php");

class BuilderPhoto extends AbstractBuilder {

    const FIELD_ID = "ID"; 
    const FIELD_CHEMIN = "CHEMIN"; 
    const FIELD_ID_ACTIVITE = "ID_ACTIVITE"; 

    public function __construct($data, $error = null) {
        parent::__construct($data, $error);
    }

	public static function buildFromPhoto(Photo $photo) {
		return new BuilderPhoto(array(
			BuilderPhoto::FIELD_ID => $photo->getId(),
			BuilderPhoto::FIELD_CHEMIN => $photo->getChemin(),
			BuilderPhoto::FIELD_ID_ACTIVITE => $photo->getActivite()->getId()
		));
	}

    public function create() {
        if($this->data == null || $this->data != null && !$this->isValid()) 
            return null;
        
        $p = new Photo();
        
        if(isset($this->data[BuilderPhoto::FIELD_ID]))
            $p->setId($this->data[BuilderPhoto::FIELD_ID]);
            
        $p->setChemin($this->data[BuilderPhoto::FIELD_CHEMIN]);
        $p->setActivite(new Activite($this->data[BuilderPhoto::FIELD_ID_ACTIVITE]));

        return $p;
    }
    
    public function isValid() {
         $this->error = array();

        if(isset($this->data[BuilderPhoto::FIELD_ID]) && !is_numeric($this->data[BuilderPhoto::FIELD_ID])) {
            $this->error[BuilderPhoto::FIELD_ID] = "La valeur de l'id est incorrect";
        }

        if(empty($this->data[BuilderPhoto::FIELD_CHEMIN])) {
            $this->error[BuilderPhoto::FIELD_CHEMIN] = "La valeur du chemin est obligatoire";
        }

        if(!is_numeric($this->data[BuilderPhoto::FIELD_ID_ACTIVITE])) {
            $this->error[BuilderPhoto::FIELD_ID_ACTIVITE] = "L'id de l'activité est incorrect";
        }

        return count($this->error) == 0;
    }
    
}