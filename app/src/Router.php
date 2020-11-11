<?php

require_once("controller/Controller.php");
require_once("view/View.php");
require_once("storage/bdd/BDDActiviteStorage.php");

class Router {

    public function main() {
        $urlPath = explode("/", substr($_SERVER['PATH_INFO'], 1));

        if($urlPath[0] == "activite") {
            $ctrl = new Controller(new View($this), new BDDActiviteStorage());
            if(isset($urlPath[1]) && $urlPath[1] == "add" && $_SERVER["REQUEST_METHOD"] == "GET")
                $ctrl->showAddActivite();
            elseif(isset($urlPath[1]) && $urlPath[1] == "add" && $_SERVER["REQUEST_METHOD"] == "POST")
                $ctrl->saveNewActivite($_POST);
            elseif(isset($urlPath[1]) && isset($urlPath[2]) && $urlPath[2] == "update" && $_SERVER["REQUEST_METHOD"] == "GET")
                $ctrl->showUpdateActivite($urlPath[1]);
            elseif(isset($urlPath[1]) && isset($urlPath[2]) && $urlPath[2] == "update" && $_SERVER["REQUEST_METHOD"] == "POST")
                $ctrl->modifActivite($urlPath[1], $_POST);
            elseif(isset($urlPath[1]) && isset($urlPath[2]) && $urlPath[2] == "delete" && $_SERVER["REQUEST_METHOD"] == "GET")
                $ctrl->showDeleteActivite($urlPath[1]);
            elseif(isset($urlPath[1]) && isset($urlPath[2]) && $urlPath[2] == "delete" && $_SERVER["REQUEST_METHOD"] == "POST")
                $ctrl->deleteActivite($urlPath[1]);
            elseif(isset($urlPath[1]))
                $ctrl->showInformation($urlPath[1]);
            else 
                $ctrl->showList();
        } else {
            echo "404";
        }
    } 

    public function getActiviteURL($id) {
        return "/activite/" . $id;
    }

    public function getActiviteCreationURL() {
        return "/activite/add";
    }

    public function getActiviteModifURL($id) {
        return "/activite/" . $id . "/update";
    }

    public function getActiviteSupprimerURL($id) {
        return "/activite/" . $id . "/delete";
    }

}