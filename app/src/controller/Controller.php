<?php

require_once("model/Activite.php");
require_once("model/builder/BuilderActivite.php");
require_once("model/builder/BuilderLogin.php");
require_once("storage/bdd/BDDActiviteStorage.php");
require_once("storage/bdd/BDDUtilisateurStorage.php");
require_once("AuthenticationManager.php");
require_once("view/View.php");

class Controller {

    protected $view;
    protected $router;

    protected $bdd;

    public function __construct(View $view, $bdd) {
        $this->view = $view;
        $this->router = Router::getInstance();
        $this->bdd = $bdd;
    }

    public function about() {
        $this->view->makeAboutPage();
    }

    public function showActivite($id) {
        $activiteStorage = new BDDActiviteStorage($this->bdd);

        $activite = $activiteStorage->read($id);

        if($activite != null)
            $this->view->makeActivitePage($activite);
        else 
            $this->view->make404Page();
    }

    public function listActivites() {
        $activiteStorage = new BDDActiviteStorage($this->bdd);

        $this->view->makeListActivitePage($activiteStorage->readAll());
    }

    public function showAddActivite() {
        $authManager = new AuthenticationManager();
        if(!$authManager->isConnected()) {
            $this->router->POSTRedirect($this->router->get404URL());
        }

        $builder = $this->router->getFormData();
        if($builder == null) {
            $builder = new BuilderActivite(array());
        }

        $this->view->makeActiviteFormPage($builder);
    }

    public function addActivite(array $data) {
        $authManager = new AuthenticationManager();
        if(!$authManager->isConnected()) {
            $this->router->POSTRedirect($this->router->get404URL());
        }

        $builder = new BuilderActivite($data);
        $builder->setAttribute(BuilderActivite::FIELD_ID_UTILISATEUR, $authManager->getUser()->getId());
        
        if($builder->isValid()) {
            $activiteStorage = new BDDActiviteStorage($this->bdd);
            $id = $activiteStorage->create($builder->create());

            $this->router->POSTRedirect($this->router->getActiviteURL($id), "Création réussie");
            return;
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getActiviteCreationURL(), "Formulaire invalide");
            return;
        }
    }

    public function isUserActivityOwner($activite) {
        $authManager = new AuthenticationManager();
        if($activite == null || !$authManager->isConnected() || !$authManager->isAdmin() && $activite->getUtilisateur()->getId() != $authManager->getUser()->getId()) {
            return false;
        }
        
        return true;
    }

    public function showUpdateActivite($id) {
        $activiteStorage = new BDDActiviteStorage($this->bdd);
        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $builder = $this->router->getFormData();
        if($builder == null) {              
            $builder = BuilderActivite::buildFromActivite($activite);
        }

        $this->view->makeActiviteFormPage($builder, true);
    }

    public function updateActivite($id, array $data) {
        $activiteStorage = new BDDActiviteStorage($this->bdd);
        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }
        
        $builder = new BuilderActivite($data);
        $builder->setAttribute(BuilderActivite::FIELD_ID_UTILISATEUR, $activite->getUtilisateur()->getId());

        if($builder->isValid()) {
            $activiteStorage->update($id, $builder->create());
            $this->router->POSTRedirect($this->router->getActiviteURL($id), "Modfication réussie");
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getActiviteModifURL($id), "Formulaire invalide");
        }
    }

    public function showDeleteActivite($id) {
        $activiteStorage = new BDDActiviteStorage($this->bdd);
        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $this->view->makeDeleteActivitePage($id);
    }

    public function deleteActivite($id) {
        $activiteStorage = new BDDActiviteStorage($this->bdd);
        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $activiteStorage->delete($id);
        $this->router->POSTRedirect($this->router->getActiviteListURL(), "Suppression réussie");
    }

    public function showLogin() {
        $builder = $this->router->getFormData();
        if($builder == null) {
            $builder = new BuilderLogin(array());
        }

        $this->view->makeLoginFormPage($builder);
    }

    public function login(array $data) {
        $builder = new BuilderLogin($data);
        if($builder->isValid()) {
            $authManager = new AuthenticationManager();

            if($authManager->connectUser($builder->getAttribute(BuilderLogin::FIELD_LOGIN), $builder->getAttribute(BuilderLogin::FIELD_PASSWORD), $this->bdd)) {
                $this->router->setFormData($builder);
                $this->router->POSTRedirect($this->router->getIndexURL(), "Connexion réussie");
                return;
            } else {
                $this->router->POSTRedirect($this->router->getLoginURL(), "Le couple login / mot de passe est invalide");
                return;
            }
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getLoginURL(), "Formulaire invalide");
            return;
        }
    }

    public function logout() {
        $authManager = new AuthenticationManager();
        $authManager->disconnectUser();

        $this->router->POSTRedirect($this->router->getIndexURL(), "Déconnexion réussie");
    }
}