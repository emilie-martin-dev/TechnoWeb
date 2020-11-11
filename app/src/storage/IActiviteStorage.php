<?php

require_once("model/Activite.php");

interface IActiviteStorage {

    public function read($id);

    public function readByName($name);

    public function readAll();

    public function create(Activite $activite);

    public function update($id, Activite $activite);

    public function delete($id);

}