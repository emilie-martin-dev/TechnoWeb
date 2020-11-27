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

    public function __construct(View $view) {
        $this->view = $view;
        $this->router = Router::getInstance();
    }

    public function showInformation($id) {
        $activiteStorage = new BDDActiviteStorage();

        $activite = $activiteStorage->read($id);

        if($activite != null)
            $this->view->makeActivitePage($activite);
        else 
            $this->view->make404Page();
    }

    public function showList() {
        $activiteStorage = new BDDActiviteStorage();

        $this->view->makeListPage($activiteStorage->readAll());
    }

    public function showAddActivite() {
        $builder = $this->router->getFormData();
        if($builder == null) {
            $builder = new BuilderActivite(array());
        }

        $this->view->makeActiviteFormPage($builder);
    }

    public function saveNewActivite(array $data) {
        $activiteStorage = new BDDActiviteStorage();

        $builder = new BuilderActivite($data);
        $builder->setAttribute(BuilderActivite::FIELD_ID_UTILISATEUR, 1);
        
        if($builder->isValid()) {
            $id = $activiteStorage->create($builder->create());

            $this->router->POSTRedirect($this->router->getActiviteURL($id), "Création réussie");
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getActiviteCreationURL(), "Formulaire invalide");
        }
    }

    public function showUpdateActivite($id) {
        $activiteStorage = new BDDActiviteStorage();

        $builder = $this->router->getFormData();
        if($builder == null) {
            $activite = $activiteStorage->read($id);

            if($activite == null) {
                $this->view->make404Page();
                return;
            }
                
            $builder = BuilderActivite::buildFromActivite($activiteStorage->read($id));
        }

        $this->view->makeActiviteFormPage($builder, true);
    }

    public function modifActivite($id, array $data) {
        $activiteStorage = new BDDActiviteStorage();

        $builder = new BuilderActivite($data);
        $builder->setAttribute(BuilderActivite::FIELD_ID_UTILISATEUR, 1);

        if($builder->isValid()) {
            $activiteStorage->update($id, $builder->create());

            $this->router->POSTRedirect($this->router->getActiviteURL($id), "Modfication réussie");
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getActiviteModifURL($id), "Formulaire invalide");
        }
    }

    public function showDeleteActivite($id) {
        $activiteStorage = new BDDActiviteStorage();

        if($activiteStorage->read($id) == null)
            $this->view->make404Page();
        else
            $this->view->makeDeleteActivite($id);
    }

    public function deleteActivite($id) {
        $activiteStorage = new BDDActiviteStorage();

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
        var_dump($data);
        $builder = new BuilderLogin($data);
        if($builder->isValid()) {
            $authManager = new AuthenticationManager();

            if($authManager->connectUser($builder->getAttribute(BuilderLogin::FIELD_LOGIN), $builder->getAttribute(BuilderLogin::FIELD_PASSWORD))) {
                $this->router->setFormData($builder);
                $this->router->POSTRedirect($this->router->getIndexURL(), "Connexion réussie");
            } else {
                $this->router->POSTRedirect($this->router->getLoginURL(), "Le couple login / mot de passe est invalide");
            }
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getLoginURL(), "Formulaire invalide");
        }
    }

    public function logout() {
        $authManager = new AuthenticationManager();
        $authManager->disconnectUser();

        $this->router->POSTRedirect($this->router->getIndexURL(), "Déconnexion réussie");
    }
}