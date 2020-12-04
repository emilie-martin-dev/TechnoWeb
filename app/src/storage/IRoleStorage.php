<?php

interface IRoleStorage {

    public function read($id);

    public function readByLibelle($libelle);

}