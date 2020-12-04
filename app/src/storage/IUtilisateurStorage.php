<?php

interface IUtilisateurStorage {

    public function create(Utilisateur $utilisateur);

    public function readByLogin($login);

    public function read($id);

    public function checkAuth($login, $password);

}