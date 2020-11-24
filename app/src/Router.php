<?php

require_once("controller/Controller.php");
require_once("view/View.php");
require_once("storage/bdd/BDDActiviteStorage.php");

class Router {

    const SESSION_FORM_URL = "formUrl";
    const SESSION_FORM = "form";
    const SESSION_FEEDBACK = "feedback";

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

        $urlPath = explode("/", substr($_SERVER["PATH_INFO"], 1));
        if(!empty($urlPath) && empty($urlPath[count($urlPath) - 1]))
            unset($urlPath[count($urlPath) - 1]);

        $ctrl = new Controller(new View($_SESSION[Router::SESSION_FEEDBACK]));

        if($urlPath[0] == "activite") {
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
        } elseif($urlPath[0] == "login") {
            if($_SERVER["REQUEST_METHOD"] == "GET")
                $ctrl->showLogin();
            if($_SERVER["REQUEST_METHOD"] == "POST")
                $ctrl->login($_POST);
        } elseif($urlPath[0] == "logout") {
            $ctrl->logout();
        } else {
            echo "404";
        }
    } 

    public function POSTredirect($url, $feedback="") {
        $_SESSION[Router::SESSION_FEEDBACK] = $feedback;

        header("Location: " . $url, true, 303);
    }

    public function getFormData() {
        return (isset($_SESSION[Router::SESSION_FORM])) ? $_SESSION[Router::SESSION_FORM] : null;
    }

    public function setFormData($formData) {
        $_SESSION[Router::SESSION_FORM] = $formData;
        $_SESSION[Router::SESSION_FORM_URL] = $_SERVER["PATH_INFO"];
    }

    public function getIndexURL() {
        return "/";
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

    public function getLoginURL() {
        return "/login";
    }

    public function getLogoutURL() {
        return "/logout";
    }
}