<?php

require_once("model/Photo.php");

interface IPhotoStorage {

    public function read($id);

    public function readAllByActiviteId($activiteId);

    public function create(Photo $photo);

    public function delete($id);

}