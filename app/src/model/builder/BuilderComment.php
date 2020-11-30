<?php

require_once("model/builder/AbstractBuilder.php");
require_once("model/Comment.php");

class BuilderComment extends AbstractBuilder {

    const FIELD_ID = "ID";
    const FIELD_TEXTE = "TEXTE";
    const FIELD_ID_ACTIVITE = "ID_ACTIVITE";
    const FIELD_ID_UTILISATEUR = "ID_UTILISATEUR";

    public function __construct($data, $error = null) {
        parent::__construct($data, $error);
    }

	public static function buildFromComment(Comment $comment) {
		return new BuilderComment(array(
			BuilderComment::FIELD_ID => $comment->getId(),
			BuilderComment::FIELD_TEXTE => $comment->getTexte(),
            BuilderComment::FIELD_ID_ACTIVITE => $comment->getActivite()->getId(),
			BuilderComment::FIELD_ID_UTILISATEUR => $comment->getUtilisateur()->getId()
		));
	}

    public function create() {
        if($this->data == null || $this->data != null && !$this->isValid())
            return null;

        $c = new Comment();

        if(isset($this->data[BuilderComment::FIELD_ID]))
            $c->setId($this->data[BuilderComment::FIELD_ID]);

        $c->setTexte($this->data[BuilderComment::FIELD_TEXTE]);
        $c->setActivite(new Activite($this->data[BuilderComment::FIELD_ID_ACTIVITE]));
        $c->setUtilisateur(new Utilisateur($this->data[BuilderComment::FIELD_ID_UTILISATEUR]));


        return $c;
    }

    public function isValid() {
        $this->error = array();

        if(isset($this->data[BuilderComment::FIELD_ID]) && !is_numeric($this->data[BuilderComment::FIELD_ID])) {
            $this->error[BuilderComment::FIELD_ID] = "La valeur de l'id est incorrect";
        }

        if(empty($this->data[BuilderComment::FIELD_TEXTE])) {
            $this->error[BuilderComment::FIELD_TEXTE] = "Le commentaire est obligatoire";
        }

        if(!is_numeric($this->data[BuilderComment::FIELD_ID_ACTIVITE])) {
            $this->error[BuilderComment::FIELD_ID_ACTIVITE] = "L'id de l'activité est incorrect";
        }

        if(!is_numeric($this->data[BuilderComment::FIELD_ID_UTILISATEUR])) {
            $this->error[BuilderComment::FIELD_ID_UTILISATEUR] = "L'id de l'utilisateur est incorrect";
        }

        return count($this->error) == 0;
    }

}
