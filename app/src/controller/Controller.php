<?php

require_once("model/Activite.php");
require_once("model/builder/BuilderActivite.php");
require_once("storage/IActiviteStorage.php");
require_once("view/View.php");

class Controller {

    protected $view;
    protected $activiteStorage;

    public function __construct(View $view, IActiviteStorage $activiteStorage) {
        $this->view = $view;
        $this->activiteStorage = $activiteStorage;
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
        $this->view->makeActiviteCreationPage(new BuilderActivite(array()));
    }

    public function saveNewActivite(array $data) {
        $builder = new BuilderActivite($data);
        if($builder->isValid())
            $this->activiteStorage->create($builder->create());

        $this->view->makeActiviteCreationPage($builder);
    }

    public function showUpdateActivite($id) {
        $activite = $this->activiteStorage->read($id);

        if($activite != null) {
            $builder = BuilderActivite::buildFromActivite($this->activiteStorage->read($id));
            $this->view->makeActiviteCreationPage($builder, true);
        } else {
            $this->view->makeErrorPage();
        }           
    }

    public function modifActivite($id, array $data) {
        $builder = new BuilderActivite($data);
        if($builder->isValid())
            $this->activiteStorage->update($id, $builder->create());

        $this->showInformation($id);
    }

    public function showDeleteActivite($id) {
        if($this->activiteStorage->read($id) == null)
            $this->view->makeErrorPage();
        else
            $this->view->makeDeleteActivite($id);
    }

    public function deleteActivite($id) {
        $this->activiteStorage->delete($id);

        $this->showList();
    }
}
