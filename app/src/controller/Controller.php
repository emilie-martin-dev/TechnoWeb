<?php

require_once("auth/AuthenticationManager.php");
require_once("model/Activite.php");
require_once("model/builder/BuilderActivite.php");
require_once("model/builder/BuilderLogin.php");
require_once("storage/StorageFactory.php");
require_once("utils/PhotoUploader.php");
require_once("view/View.php");

class Controller {

    protected $view;
    protected $router;

    public function __construct(View $view) {
        $this->view = $view;
        $this->router = Router::getInstance();
    }

    public function about() {
        $this->view->makeAboutPage();
    }

    public function showActivite($id) {
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

        $activite = $activiteStorage->read($id);

        if($activite != null) {
            $photoStorage = $factory->getPhotoStorage();

            $imgs = $photoStorage->readAllByActiviteId($activite->getId());
            $imgSrc = null;
            if(!empty($imgs)) {
                $imgSrc = $imgs[0]->getChemin();
            }

            $this->view->makeActivitePage($activite, $imgSrc);
        } else {
            $this->view->make404Page();
        }
    }

    public function listActivites() {
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

        $this->view->makeListActivitePage($activiteStorage->readAll());
    }

    public function showAddActivite() {
        $authManager = new AuthenticationManager();
        if(!$authManager->isConnected()) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
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
            return;
        }

        $builder = new BuilderActivite($data);
        $builder->setAttribute(BuilderActivite::FIELD_ID_UTILISATEUR, $authManager->getUser()->getId());

        if($builder->isValid()) {
            $factory = StorageFactory::getInstance();
            $activiteStorage = $factory->getActiviteStorage();
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
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

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
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

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

    public function showUploadPictureActivite($id) {
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $this->view->makeUploadPictureActivite($id);
    }

    public function uploadPictureActivite($id) {
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $photoUploader = new PhotoUploader($_FILES["file"]);
        if(!$photoUploader->isValid() || !$photoUploader->save()) {
            $this->router->POSTRedirect($this->router->getActiviteUploadPictureURL($id), $photoUploader->getError());
            return;
        }

        $builder = new BuilderPhoto(array());
        $builder->setAttribute(BuilderPhoto::FIELD_CHEMIN, $photoUploader->getFileName());
        $builder->setAttribute(BuilderPhoto::FIELD_ID_ACTIVITE, $id);

        if($builder->isValid()) {
            $factory = StorageFactory::getInstance();
            $photoStorage = $factory->getPhotoStorage();
            $photoStorage->create($builder->create());

            $this->router->POSTRedirect($this->router->getActiviteURL($id), "Image uploadé avec succès");
            return;
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getActiviteUploadPictureURL($id), "Un problème est survenue lors de l'upload");
            return;
        }
    }

    public function showDeleteActivite($id) {
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $this->view->makeDeleteActivitePage($id);
    }

    public function deleteActivite($id) {
        $factory = StorageFactory::getInstance();
        $activiteStorage = $factory->getActiviteStorage();

        $activite = $activiteStorage->read($id);

        if(!$this->isUserActivityOwner($activite)) {
            $this->router->POSTRedirect($this->router->get404URL());
            return;
        }

        $activiteStorage->delete($id);
        $this->router->POSTRedirect($this->router->getActiviteListURL(), "Suppression réussie");
    }

    public function showSign_up() {
        $builder = $this->router->getFormData();
        if($builder == null) {
            $builder = new BuilderUtilisateur(array());
        }

        $this->view->makeSignUpFormPage($builder);
    }

    public function sign_up(array $data) {
        $factory = StorageFactory::getInstance();
        $roleStorage = $factory->getRoleStorage();
        $utilisateurStorage = $factory->getUtilisateurStorage();

        $builder = new BuilderUtilisateur($data);
        $builder->setAttribute(BuilderUtilisateur::FIELD_ID_ROLE, $roleStorage->readByLibelle(ROLE_USER)->getId());

        if($utilisateurStorage->readByLogin($builder->getAttribute(BuilderUtilisateur::FIELD_LOGIN)) != null){
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getSignUpURL(), "Login déjà utiliser");
            return;
        } else if($builder->isValid()){
            $utilisateurStorage->create($builder->create());

            $this->router->POSTRedirect($this->router->getLoginURL(), "Création utilisateur réussie. Vous pouvez maintenant vous connecter.");
            return;
        } else{
            $this->router->setFormData($builder);
            $this->router->POSTRedirect($this->router->getSignUpURL(), "Formulaire non valide");
            return;
        }
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

            if($authManager->connectUser($builder->getAttribute(BuilderLogin::FIELD_LOGIN), $builder->getAttribute(BuilderLogin::FIELD_PASSWORD))) {
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
