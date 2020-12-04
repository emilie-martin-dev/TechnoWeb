<?php

require_once("model/Comment.php");

interface ICommentStorage{

    public function read($id);

    public function readByIdActivite($idActivite);

    public function create(Comment $c);

}
