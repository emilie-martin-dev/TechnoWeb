<?php

require_once("model/Comment.php");

interface ICommentStorage{


    public function read($id);

    public function readByIdActivite($id_activite);

    public function readByIdUtilisateur($id_utilisateur);

    public function create(Comment $c);

}
