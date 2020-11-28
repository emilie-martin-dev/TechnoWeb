<?php

require_once("storage/bdd/BDDRoleStorage.php");
require_once("storage/bdd/BDDUtilisateurStorage.php");

class AuthenticationManager {

    const SESSION_USER = "USER";

    public function __construct() {
    }

    public function connectUser($login, $password, $bdd) {		
        $utilisateurStorage = new BDDUtilisateurStorage($bdd);
		
		$user = $utilisateurStorage->checkAuth($login, $password);
		if($user == null)
			return false;
		
		$roleStorage = new BDDRoleStorage($bdd);
		$user->setRole($roleStorage->read($user->getRole()->getId()));
		
		$this->setUser($user);

		return true;
	}
	
	public function isConnected() {
		return $this->getUser() != null;
	}
	
	public function isAdminConnected() {
		return $this->isConnected() && $this->getUser()->getRole()->getLibelle() == ROLE_ADMIN;
	}
	
	public function getUserName() {
		if(!$this->isConnected())
			throw new Exception ("Aucun utilisateur de connecté");
	
		return $this->getUser()->getPrenom() . " " . strtoupper($this->getUser()->getName());
	}
	
	public function disconnectUser() {
		session_destroy();
	}

    public function getUser() {
        return isset($_SESSION["USER"]) ? $_SESSION[AuthenticationManager::SESSION_USER] : null;
    }

    public function setUser($utilisateur) {
        $_SESSION[AuthenticationManager::SESSION_USER] = $utilisateur;
    }
}
