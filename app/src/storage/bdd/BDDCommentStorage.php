<?php

require_once("storage/ICommentStorage.php");
require_once("model/Comment.php");

class BDDCommentStorage implements ICommentStorage {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function read($id) {
        $sth = $this->bdd->prepare("SELECT * FROM COMMENTAIRE WHERE ID = :id");
        $sth->bindValue(":id", $id, PDO::PARAM_INT);
        $sth->execute();

        $builder = new BuilderComment($sth->fetch(PDO::FETCH_ASSOC));

        return $builder->create();
    }

    public function readByIdActivite($idActivite) {
        $sth = $this->bdd->prepare("SELECT * FROM COMMENTAIRE WHERE ID_ACTIVITE  = :id_activite");
        $sth->bindValue(":id_activite", $idActivite, PDO::PARAM_INT);
        $sth->execute();

        $comment = array();

        foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $builder = new BuilderComment($r);
            $comment[] = $builder->create();
        }

        return $comment;
    }

    public function create(Comment $c) {
        $sth = $this->bdd->prepare("INSERT INTO COMMENTAIRE VALUES(NULL, :texte, :id_activite, :id_utilisateur)");
        $sth->bindValue(":texte", $c->getTexte());
        $sth->bindValue(":id_activite", $c->getActivite()->getId(), PDO::PARAM_INT);
        $sth->bindValue(":id_utilisateur", $c->getUtilisateur()->getId(), PDO::PARAM_INT);

        $sth->execute();

        return $this->bdd->lastInsertId();
    }

}
