<?php

interface IUtilisateurStorage {

    public function checkAuth($login, $password);

}