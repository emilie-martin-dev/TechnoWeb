<?php

require_once("model/Activite.php");

require_once("storage/IActiviteStorage.php");

class Controller {

    protected View $view;
    protected IActiviteStorage $activiteStorage;

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

}