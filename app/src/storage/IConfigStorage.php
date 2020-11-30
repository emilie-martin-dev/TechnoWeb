<?php

require_once("model/Config.php");

interface IConfigStorage {

    public function read($id);

    public function readLibelle($libelle);

    public function updateValeurs($id, Config $config);

}
