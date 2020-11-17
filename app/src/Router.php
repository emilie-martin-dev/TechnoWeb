<?php

require_once("controller/Controller.php");
require_once("view/View.php");
require_once("storage/bdd/BDDActiviteStorage.php");

class Router {

    const SESSION_FORM_URL = "formUrl";
    const SESSION_FORM = "form";

    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
        if(Router::$instance == null) {
            Router::$instance = new Router();  
        }

        return Router::$instance;
    }

    public function main() {
        session_name("ActivNormandie");
        session_start();

        if(isset($_SESSION[Router::SESSION_FORM_URL]) && $_SESSION[Router::SESSION_FORM_URL] != $_SERVER["PATH_INFO"]) {
            unset($_SESSION[Router::SESSION_FORM_URL]);
            unset($_SESSION[Router::SESSION_FORM]);
        }

        $_SESSION["test"] = "coucou";
        $urlPath = explode("/", substr($_SERVER["PATH_INFO"], 1));
        if(!empty($urlPath) && empty($urlPath[count($urlPath) - 1]))
            unset($urlPath[count($urlPath) - 1]);

        if($urlPath[0] == "activite") {
            $ctrl = new Controller(new View(), new BDDActiviteStorage());
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

    public function POSTredirect($url, $feedback="") {
        $_SESSION['feedback'] = $feedback;

        header("Location: " . $url, true, 303);
    }

    public function getFormData() {
        return (isset($_SESSION[Router::SESSION_FORM])) ? $_SESSION[Router::SESSION_FORM] : null;
    }

    public function setFormData($formData) {
        $_SESSION[Router::SESSION_FORM] = $formData;
        $_SESSION[Router::SESSION_FORM_URL] = $_SERVER["PATH_INFO"];
    }

    public function getActiviteListURL() {
        return "/activite";
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