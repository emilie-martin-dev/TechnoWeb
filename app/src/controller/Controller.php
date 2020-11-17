<?php

require_once("model/Activite.php");
require_once("model/builder/BuilderActivite.php");
require_once("storage/IActiviteStorage.php");
require_once("view/View.php");

class Controller {

    protected $view;
    protected $activiteStorage;
    protected $router;

    public function __construct(View $view, IActiviteStorage $activiteStorage) {
        $this->view = $view;
        $this->activiteStorage = $activiteStorage;
        $this->router = Router::getInstance();
    }

    public function showInformation(String $id) {
        $activite = $this->activiteStorage->read($id);

        if($activite != null)
            $this->view->makeActivitePage($activite);
        else 
            $this->view->makeErrorPage();
    }

    public function showList() {
        $this->view->makeListPage($this->activiteStorage->readAll());
    }

    public function showAddActivite() {
        $builder = $this->router->getFormData();
        if($builder == null) {
            $builder = new BuilderActivite(array());
        }

        $this->view->makeActiviteCreationPage($builder);
    }

    public function saveNewActivite(array $data) {
        $builder = new BuilderActivite($data);
        
        if($builder->isValid()) {
            $id = $this->activiteStorage->create($builder->create());

            $this->router->POSTredirect($this->router->getActiviteURL($id), "Création réussie");
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTredirect($this->router->getActiviteCreationURL(), "Formulaire invalide");
        }
    }

    public function showUpdateActivite($id) {
        $builder = $this->router->getFormData();
        if($builder == null) {
            $activite = $this->activiteStorage->read($id);

            if($activite == null) {
                $this->view->makeErrorPage();
                return;
            }
                
            $builder = BuilderActivite::buildFromActivite($this->activiteStorage->read($id));
            
        }

        $this->view->makeActiviteCreationPage($builder, true);
    }

    public function modifActivite($id, array $data) {
        $builder = new BuilderActivite($data);
        if($builder->isValid()) {
            $this->activiteStorage->update($id, $builder->create());

            $this->router->POSTredirect($this->router->getActiviteURL($id), "Modfication réussie");
        } else {
            $this->router->setFormData($builder);
            $this->router->POSTredirect($this->router->getActiviteModifURL($id), "Formulaire invalide");
        }
    }

    public function showDeleteActivite($id) {
        if($this->activiteStorage->read($id) == null)
            $this->view->makeErrorPage();
        else
            $this->view->makeDeleteActivite($id);
    }

    public function deleteActivite($id) {
        $this->activiteStorage->delete($id);

        $this->router->POSTredirect($this->router->getActiviteListURL(), "Suppression réussie");
    }
}
