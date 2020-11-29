<?php

require_once("storage/StorageFactory.php");

class AuthenticationManager {

    public function __construct() {
    }

    public function connectUser($login, $password) {		
        $factory = StorageFactory::getInstance();		
        $utilisateurStorage = $factory->getUtilisateurStorage();
		
		$user = $utilisateurStorage->checkAuth($login, $password);
		if($user == null)
			return false;
		
		$roleStorage = $factory->getRoleStorage();
		$user->setRole($roleStorage->read($user->getRole()->getId()));
		
		$this->setUser($user);

		return true;
	}
	
	public function isConnected() {
		return $this->getUser() != null;
	}
	
	public function isAdmin() {
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
        return isset($_SESSION["USER"]) ? $_SESSION[SESSION_USER] : null;
    }

    public function setUser($utilisateur) {
        $_SESSION[SESSION_USER] = $utilisateur;
    }
}
